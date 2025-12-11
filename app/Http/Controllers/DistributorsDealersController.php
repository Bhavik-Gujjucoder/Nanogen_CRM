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
use App\Models\SalesPersonDetail;
use App\Models\DistributorsDealersDocuments;
use App\Exports\DistributorDealerExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DistributorsDealersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('Distributors & Dealers');
        // if ($request->dealer == 1) {
        //     $this->authorize('Dealers'); // or use: Gate::authorize('Dealer Access');
        // } else {
        //     $this->authorize('Distributors');
        // }

        $data['sales_persons'] = SalesPersonDetail::get();
        $data['page_title'] = $request->dealer == 1 ? 'Dealers' : 'Distributors';

        if ($request->ajax()) {

            $data = DistributorsDealers::where('user_type', $request->dealer ? 2 : 1)
                ->when($request->sales_person_id, function ($query, $sales_person_id) {
                    return $query->where('sales_person_id', $sales_person_id);
                })

                /* Filter by start_date & end_date */
                ->when($request->start_date, function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', Carbon::parse($request->start_date)->format('Y-m-d'));
                })
                ->when($request->end_date, function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', Carbon::parse($request->end_date)->format('Y-m-d'));
                });


            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('checkbox', function ($row) {
                //     return '<label class="checkboxs">
                //             <input type="checkbox" class="checkbox-item grade_checkbox" data-id="' . $row->id . '">
                //             <span class="checkmarks"></span>
                //         </label>';
                // })
                ->addColumn('action', function ($row) use ($request) {
                    // $payment_history = '<a href="' . route('distributors_dealers.payment_history', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    // class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Payment History</a>';

                    $edit_btn = '<a href="' . route('distributors_dealers.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $o_form_download_btn = '<a href="' . route('distributors_dealers.replaceInWord', ['id' => $row->id, 'dealer' => ($row->user_type == 2 ? 1 :  null)]) . '" class="dropdown-item"  data-id="' . $row->id . '" class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-download text-warning"></i> O-Form Download</a>';

                    $principal_certificate_download_btn = '<a href="' . route('distributors_dealers.replaceInWord', ['id' => $row->id, 'dealer' => ($row->user_type == 2 ? 1 :  null)]) . '" class="dropdown-item"  data-id="' . $row->id . '" class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-download text-warning"></i> Principal Certificate Download</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item delete_d_d"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('distributors_dealers.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage users') ? $action_btn .= $payment_history : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $o_form_download_btn : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';
                    $o_form_licence_check = $row->fertilizer_license_check == 1 ? true : false;
                    $pesticide_license_check = $row->pesticide_license_check == 1 ? true : false;
                    $action_btn .= $o_form_licence_check ? $o_form_download_btn : '';
                    $action_btn .= $pesticide_license_check ? $principal_certificate_download_btn : '';

                    $action_btn .= $edit_btn;
                    // $action_btn .= $o_form_download_btn;
                    // $action_btn .= $principal_certificate_download_btn;
                    $action_btn .= $delete_btn;

                    return $action_btn . ' </div></div>';
                })
                ->editColumn('applicant_name', function ($row) {
                    $profilePic = isset($row->profile_image)
                        ? asset('storage/distributor_dealer_profile_image/' . $row->profile_image)
                        : asset('images/default-user.png');

                    return '
                        <a href="' . $profilePic . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                            <img src="' . $profilePic . '" alt="User Image">
                        </a>' . $row->applicant_name;
                })
                ->editColumn('sales_person_id', function ($row) {
                    return $row->sales_person ? $row->sales_person->first_name . ' ' . $row->sales_person->last_name : '-';
                })
                ->editColumn('city_id', function ($row) {
                    return $row->city ? $row->city->city_name : '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y') : '-';
                })
                ->filterColumn('city_id', function ($query, $keyword) {
                    $query->whereHas('city', function ($q) use ($keyword) {
                        $q->where('city_name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['action', 'applicant_name'])
                ->make(true);
        }
        return view('admin.distributors_dealers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['page_title'] = $request->dealer == 1 ? 'Create Dealers' : 'Create Distributors';
        // $data['page_title'] = 'Create Distributors and Dealers';
        $data['products']   = Product::where('status', 1)->get()->all();
        $data['states']     = StateManagement::where('status', 1)->get()->all();
        $data['countries']  = Country::where('status', 1)->get()->all();
        $data['sales_persons'] = SalesPersonDetail::get();
        return view('admin.distributors_dealers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
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

            // if ($request->has(['company_name', 'product_id', 'quantity', 'company_remarks'])) {

            $company_name    = $request->input('company_name');
            $product_id      = $request->input('product_id');
            $quantity        = $request->input('quantity');
            $company_remarks = $request->input('company_remarks');
            if (!empty($company_name)) {
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

            // if ($request->has(['name', 'birthdate', 'address'])) {
            $name      = $request->input('name');
            $birthdate = $request->input('birthdate');
            $address   = $request->input('address');

            if (!empty($name)) {
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
        // $data['page_title'] = $request->dealer == 1 ? 'Create Dealers' : 'Create Distributors';
        $data = [
            'page_title'          =>  $distributor_dealers->user_type == 1 ? 'Edit Distributor' : 'Edit Dealer',
            'distributor_dealers' => $distributor_dealers,
            'products'            => Product::where('status', 1)->get()->all(),
            'states'              => StateManagement::where('status', 1)->get()->all(),
            'countries'           => Country::where('status', 1)->get()->all(),
            'sales_persons'       => SalesPersonDetail::get(),
        ];
        return view('admin.distributors_dealers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        try {
            $d_d = DistributorsDealers::findOrFail($id);
            $data = $request->all();

            if ($request->has('fertilizer_license_check')) {
                $data['fertilizer_license_check'] = 1;
                $data['fertilizer_license'] = $request->fertilizer_license;
            } else {
                // Checkbox unchecked → reset both fields
                $data['fertilizer_license_check'] = 0;
                $data['fertilizer_license'] = null;
            }

            // If checkbox is checked
            if ($request->has('pesticide_license_check')) {
                $data['pesticide_license_check'] = 1;
                $data['pesticide_license'] = $request->pesticide_license;
            } else {
                // Checkbox unchecked → reset both fields
                $data['pesticide_license_check'] = 0;
                $data['pesticide_license'] = null;
            }

            $d_d->update($data);

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

            // if ($request->has(['company_name', 'product_id', 'quantity', 'company_remarks'])) {
            DealershipCompanies::where('dd_id', $id)->delete();
            $company_name    = $request->input('company_name');
            $product_id      = $request->input('product_id');
            $quantity        = $request->input('quantity');
            $company_remarks = $request->input('company_remarks');
            if (!empty($company_name)) {
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
            // }

            // if ($request->has(['name', 'birthdate', 'address'])) {
            ProprietorPartnerDirector::where('dd_id', $id)->delete();
            $names      = $request->input('name');
            $birthdate = $request->input('birthdate');
            $address   = $request->input('address');

            if (!empty($names)) {
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
        //  return $pdf->stream($filename);   //only pdf view perpose  

    }


    public function replaceInWord(Request $request, $id, $dealer = null)
    {
        // dd($request->all);
        $d_d = DistributorsDealers::findOrFail($id);
        // Load the template
        // $templatePath = storage_path('app\public\NANOGEN_O_FORM.docx');

        $templatePath = storage_path('app/public/O-Form/NANOGEN-O-FORM.docx');

        $templateProcessor = new TemplateProcessor($templatePath);

        // Replace placeholders
        $templateProcessor->setValue('Firm_Name', $d_d->firm_shop_name);
        $templateProcessor->setValue('Firm_Address', $d_d->firm_shop_address);

        $name = ($request->dealer == 1) ? $d_d->applicant_name . '(Dealer)' : $d_d->applicant_name . '(Distributor)';

        $fileName = $name . 'O-Form.docx';
        $savePath = storage_path("app/public/{$fileName}");
        $templateProcessor->saveAs($savePath);

        return response()->download($savePath);
    }

    public function export(Request $request, $dealer = null)
    {
        // dd($dealer); dealer no type su che 1 k 2
        $query = DistributorsDealers::with('sales_person')
            ->where('user_type', $dealer ? 2 : 1)
            ->when($request->sales_person_id, function ($q, $sales_person_id) {
                return $q->where('sales_person_id', $sales_person_id);
            })
            ->when($request->start_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', Carbon::parse($request->start_date)->format('Y-m-d'));
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', Carbon::parse($request->end_date)->format('Y-m-d'));
            });
        $data = $query->get();
        return Excel::download(new DistributorDealerExport($data), 'distributors_dealers.xlsx');
    }
}
