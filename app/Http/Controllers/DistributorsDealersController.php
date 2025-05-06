<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Mpdf\HTMLParserMode;
use Illuminate\Http\Request;
use Mpdf\Config\FontVariables;
use App\Models\StateManagement;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Config\ConfigVariables;
use Yajra\DataTables\DataTables;
use App\Models\DealershipCompanies;
use App\Models\DistributorsDealers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\ProprietorPartnerDirector;
use App\Models\DistributorsDealersDocuments;

class DistributorsDealersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $data['page_title'] = $request->dealer == 1 ? 'Dealers' : 'Distributors';
        if ($request->ajax()) {

            $data = DistributorsDealers::where('user_type', $request->dealer ? 2 : 1);

            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('checkbox', function ($row) {
                //     return '<label class="checkboxs">
                //             <input type="checkbox" class="checkbox-item grade_checkbox" data-id="' . $row->id . '">
                //             <span class="checkmarks"></span>
                //         </label>';
                // })
                ->addColumn('action', function ($row) use ($request){
                    // $payment_history = '<a href="' . route('distributors_dealers.payment_history', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    // class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Payment History</a>';

                    $edit_btn = '<a href="' . route('distributors_dealers.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $o_form_download_btn = '<a href="' . route('distributors_dealers.replaceInWord', ['id'=> $row->id, 'dealer' => ($row->user_type == 2 ? 1 :  null)]) . '" class="dropdown-item"  data-id="' . $row->id . '" class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-download text-warning"></i> O-Form Download</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item delete_d_d"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('distributors_dealers.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage users') ? $action_btn .= $payment_history : '';
                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $o_form_download_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';
                    return $action_btn . ' </div></div>';
                })
                ->editColumn('city_id', function ($row) {
                    return $row->city ? $row->city->city_name : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.distributors_dealers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create Distributors and Dealers';
        $data['products']   = Product::where('status', 1)->get()->all();
        $data['states']     = StateManagement::where('status', 1)->get()->all();
        $data['countries']  = Country::where('status', 1)->get()->all();
        return view('admin.distributors_dealers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $d_d = new DistributorsDealers();
            $d_d->fill($request->all());

            if ($request->hasFile('profile_image')) {
                $file     = $request->file('profile_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('distributor_dealer_profile_image', $filename, 'public'); /* Save to storage/app/public/distributor_dealer_profile_image */
                $d_d->profile_image = $filename;
            }
            $d_d->save();

            if ($request->has(['company_name', 'product_id', 'quantity', 'company_remarks'])) {

                $company_name    = $request->input('company_name');
                $product_id      = $request->input('product_id');
                $quantity        = $request->input('quantity');
                $company_remarks = $request->input('company_remarks');

                foreach ($company_name as $key => $company_name) {
                    if (!empty($company_name) || !empty($product_id[$key]) || !empty($quantity[$key]) || !empty($company_remarks[$key])) {
                        DealershipCompanies::create([
                            'dd_id'           => $d_d->id,
                            'company_name'    => $company_name,
                            'product_id'      => $product_id[$key],
                            'quantity'        => $quantity[$key],
                            'company_remarks' => $company_remarks[$key],
                        ]);
                    }
                }
            }

            if ($request->has(['name', 'birthdate', 'address'])) {
                $name      = $request->input('name');
                $birthdate = $request->input('birthdate');
                $address   = $request->input('address');

                foreach ($name as $key => $name) {
                    if (!empty($name) || !empty($birthdate[$key]) || !empty($address[$key])) {
                        ProprietorPartnerDirector::create([
                            'dd_id'     => $d_d->id,
                            'name'      => $name,
                            'birthdate' => $birthdate[$key],
                            'address'   => $address[$key],
                        ]);
                    }
                }
            }

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $filePath = $file->store('dd_documents', 'public'); // stored in storage/app/dd_documents

                    DistributorsDealersDocuments::create([
                        'dd_id'     => $d_d->id,
                        'file_path' => $filePath,
                        'file_name' => $originalName,
                    ]);
                }
            }
            return redirect()->route('distributors_dealers.index', ($d_d->user_type == 2))->with('success', 'Record created successfully!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $distributor_dealers = DistributorsDealers::findOrFail($id);

        $data = [
            'page_title'          => 'Edit Distributors and Dealers',
            'distributor_dealers' => $distributor_dealers,
            'products'            => Product::where('status', 1)->get()->all(),
            'states'              => StateManagement::where('status', 1)->get()->all(),
            'countries'           => Country::where('status', 1)->get()->all(),
        ];
        return view('admin.distributors_dealers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $d_d = DistributorsDealers::findOrFail($id);
            $d_d->update($request->all());

            if ($request->hasFile('profile_image')) {
                if ($d_d->profile_image) {
                    Storage::disk('public')->delete('distributor_dealer_profile_image/' . $d_d->profile_image);
                }

                $file     = $request->file('profile_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('distributor_dealer_profile_image', $filename, 'public');
                /** Save to storage/app/public/product_images **/
                $d_d->profile_image = $filename;
                $d_d->save();
            }

            if ($request->has(['company_name', 'product_id', 'quantity', 'company_remarks'])) {
                DealershipCompanies::where('dd_id', $id)->delete();
                $company_name    = $request->input('company_name');
                $product_id      = $request->input('product_id');
                $quantity        = $request->input('quantity');
                $company_remarks = $request->input('company_remarks');

                foreach ($company_name as $key => $company_name) {
                    if (!empty($company_name) || !empty($product_id[$key]) || !empty($quantity[$key]) || !empty($company_remarks[$key])) {
                        DealershipCompanies::create([
                            'dd_id'           => $d_d->id,
                            'company_name'    => $company_name,
                            'product_id'      => $product_id[$key],
                            'quantity'        => $quantity[$key],
                            'company_remarks' => $company_remarks[$key],
                        ]);
                    }
                }
            }

            if ($request->has(['name', 'birthdate', 'address'])) {
                ProprietorPartnerDirector::where('dd_id', $id)->delete();
                $names      = $request->input('name');
                $birthdate = $request->input('birthdate');
                $address   = $request->input('address');

                foreach ($names as $key => $name) {
                    if (!empty($name) || !empty($birthdate[$key]) || !empty($address[$key])) {
                        ProprietorPartnerDirector::create([
                            'dd_id'     => $d_d->id,
                            'name'      => $name,
                            'birthdate' => $birthdate[$key],
                            'address'   => $address[$key],
                        ]);
                    }
                }
            }

            if ($request->hasFile('files')) {

                foreach ($request->file('files') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $filePath = $file->store('dd_documents', 'public'); // stored in storage/app/dd_documents

                    DistributorsDealersDocuments::create([
                        'dd_id'     => $d_d->id,
                        'file_path' => $filePath,
                        'file_name' => $originalName,
                    ]);
                }
            }

            return redirect()->route('distributors_dealers.index', ($d_d->user_type == 2))->with('success', 'Record updated successfully.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $d_d = DistributorsDealers::findOrFail($id);
        DealershipCompanies::where('dd_id', $id)->delete();
        ProprietorPartnerDirector::where('dd_id', $id)->delete();
        if ($d_d->profile_image) {
            Storage::disk('public')->delete('distributor_dealer_profile_image/' . $d_d->profile_image);
        }
        $d_d->delete();
        return redirect()->route('distributors_dealers.index', ($d_d->user_type == 2))->with('success', 'Record deleted successfully!');
    }


    public function documents_destroy(string $id)
    {
        $document = DistributorsDealersDocuments::findOrFail($id);

        // Delete the file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
    
        return response()->json(['success' => true, 'message' => 'Document deleted successfully.']);
    }



    public function payment_history(Request $request, string $id)
    {
        $distributor_dealers = DistributorsDealers::findOrFail($id);
        $data = [
            'page_title' => 'Payment History',
            'distributor_dealers' => $distributor_dealers,
        ];
        return view('admin.distributors_dealers.payment_history', $data);
    }


    public function export_price_list(Request $request)  // right function
    {
        // $data['products'] = Product::with('category', 'product_variations.variation_option_value')->where('status', 1)->get();
        $data['category'] = Category::with('products')->where('status', 1)
            ->has('products')
            /***  Only get categories with products ***/
            ->get();

        // return view('admin.distributors_dealers.price_list', $data);  //only web view perpose 
        $pdf = Pdf::loadView('admin.distributors_dealers.price_list', $data);

        $name = $request->dealer == 1 ? 'Dealers' : 'Distributors';
        $filename = $name . '-price-list-' . now()->year . '.pdf';

        // Save to storage/app/public/price-lists/
        Storage::disk('public')->put('distributors-price-lists/' . $filename, $pdf->output());

        return $pdf->download($filename);
        //  return $pdf->stream($filename);   //only view perpose 

    }


    public function replaceInWord(Request $request, $id, $dealer = null)
    {
        // dd($request->all);
        $d_d = DistributorsDealers::findOrFail($id);
        // Load the template
        // $templatePath = storage_path('app\public\NANOGEN_O_FORM.docx');

        $templatePath = storage_path('app/public/O-FORM/NANOGEN-O-FORM.docx');

        $templateProcessor = new TemplateProcessor($templatePath);

        // Replace placeholders
        $templateProcessor->setValue('Firm_Name', $d_d->firm_shop_name);
        $templateProcessor->setValue('Firm_Address', $d_d->firm_shop_address);

        $name = ($request->dealer == 1) ? $d_d->applicant_name .'(Dealer)' : $d_d->applicant_name .'(Distributor)'; 

        $fileName = $name . 'O-Form.docx';
        $savePath = storage_path("app/public/{$fileName}");
        $templateProcessor->saveAs($savePath);

        return response()->download($savePath);
    }
}
