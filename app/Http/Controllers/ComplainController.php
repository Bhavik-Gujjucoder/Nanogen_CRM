<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Complain;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\DistributorsDealers;
use Illuminate\Support\Facades\Auth;
use App\Models\ComplainStatusHistory;
use Illuminate\Support\Facades\Storage;

class ComplainController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Complain';
        if ($request->ajax()) {
            $data = Complain::with('distributorsDealers');  ///query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item complain_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {

                    $edit_btn = '<a href="' . route('complain.edit', $row->id) . '" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deletecomplain"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('complain.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';


                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    $action_btn .= $edit_btn;
                    $action_btn .= $delete_btn;

                    return $action_btn . ' </div></div>';
                })
                ->editColumn('firm_shop_name', function ($row) {
                    $imagePath = 'storage/complain_images/' . $row->complain_image;
                    // $complainimage = isset($row->complain_image)
                    //     ? asset($imagePath)
                    //     : asset('images/default-user.png');

                    $profilePic = isset($row->distributorsDealers->profile_image)
                        ? asset('storage/distributor_dealer_profile_image/' . $row->distributorsDealers->profile_image)
                        : asset('images/default-user.png');

                    $userLabel = $row->distributorsDealers?->user_type == 1 ? '(Distributor)'
                        : ($row->distributorsDealers?->user_type == 2 ? '(Dealer)' : '');

                    return '
                    <a href="' . $profilePic . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                        <img src="' . $profilePic . '" alt="Complain Image">
                    </a>
                    <span>' . ($row->distributorsDealers?->firm_shop_name ?? 'N/A') . '</span><br>
                    <small>' . $userLabel . '</small>';
                })
                ->filterColumn('dd_id', function ($query, $keyword) {
                    $query->whereHas('distributorsDealers', function ($q) use ($keyword) {
                        // $q->where('applicant_name', 'like', "%{$keyword}%")
                        $q->where('firm_shop_name', 'like', "%{$keyword}%")
                            ->orWhereRaw("CASE 
                                            WHEN user_type = 1 THEN '(Distributor)' 
                                            WHEN user_type = 2 THEN '(Dealer)' 
                                            ELSE '' 
                                        END LIKE ?", ["%{$keyword}%"]);
                    });
                })
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->date)->format('d M Y');
                })
                ->addColumn('product', function ($row) {
                    return $row->product->product_name ?? '-';
                })
                ->filterColumn('product_id', function ($query, $keyword) {
                    $query->whereHas('product', function ($q) use ($keyword) {
                        $q->where('product_name', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('status', function ($complain) {
                    return $complain->statusBadge(); // Get user roles
                })
                ->rawColumns(['checkbox', 'action', 'status', 'firm_shop_name'])
                ->make(true);
        }
        return view('admin.complain.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Complain';
        $data['dds'] = DistributorsDealers::get();
        $data['products'] = Product::where('status', 1)->get();
        return view('admin.complain.create', $data);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'complain_image' => 'required|max:2048',
        // ], [
        //     'complain_image.required' => 'Complain file is required.',
        //     'complain_image.max' => 'Complain file may not be greater than 2MB',
        // ]);

        // $request->validate([
        //     'complain_image'   => 'required|array',
        //     'complain_image.*' => 'file|max:2048', // each file max 2MB
        // ], [
        //     'complain_image.required' => 'Complain file is required.',
        //     'complain_image.*.max'    => 'Each file may not be greater than 2MB.',
        // ]);

        $data = [
            'dd_id' => $request->dd_id,
            'date' => $request->date,
            'product_id' => $request->product_id,
            'status' => $request->status,
            'description' => $request->description,
            'remark' => $request->remark,
        ];


        $uploadedImages = [];

        if ($request->hasFile('complain_image')) {
            foreach ($request->file('complain_image') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('complain_images', $filename, 'public');
                $uploadedImages[] = $filename;
            }
        }

        // Store as JSON
        $data['complain_image'] = json_encode($uploadedImages);

        /*if ($request->hasFile('complain_image')) {
            $file     = $request->file('complain_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('complain_images', $filename, 'public'); // Save to storage/app/public/complain_images
            $data['complain_image'] = $filename;
        } else {
            $data['complain_image'] = null;
        }*/

        $complain = Complain::create($data);

        if (isset($request->status)) {
            $status_history = new ComplainStatusHistory();
            $history_data = [
                'complain_id' => $complain->id,
                'status' => $complain->status,
                'remark' => $complain->remark,
            ];
            $status_history->create($history_data);
        }
        return redirect()->route('complain.index')->with('success', 'Complain created successfully.');
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Complain';
        $data['dds'] = DistributorsDealers::get();
        $data['products'] = Product::where('status', 1)->get();
        $data['complain'] = Complain::findOrFail($id);
        $data['complain_status_history'] = ComplainStatusHistory::where('complain_id', $id)->orderBy('created_at', 'desc')->get();
        return view('admin.complain.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // $request->validate([
        //     'complain_image'   => 'nullable|array',
        //     'complain_image.*' => 'file|max:2048',
        // ]);
        // $request->validate([
        //     'complain_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // ], [
        //     'complain_image.image' => 'Complain image must be an image.',
        //     'complain_image.mimes' => 'Complain image must be a file of type: jpeg, png, jpg, gif.',
        //     'complain_image.max' => 'Complain image may not be greater than 2MB',
        // ]);

        $complain = Complain::findOrFail($id);


        if ((int) $complain->status !== (int) $request->status) {
            $complain_status_history = new ComplainStatusHistory();
            $complain_status_history_data = [
                'complain_id' => $id,
                'status' => $request->status,
                'remark' => $request->remark,
            ];
            $complain_status_history->create($complain_status_history_data);
        }

        $data = [
            'dd_id' => $request->dd_id,
            'date' => $request->date,
            'product_id' => $request->product_id,
            'status' => $request->status,
            'description' => $request->description,
            'remark' => $request->remark,
        ];

        // if ($request->hasFile('complain_image')) {
        //     // Delete old complain image if exists
        //     if ($complain->complain_image) {
        //         Storage::disk('public')->delete('complain_images/' . $complain->complain_image);
        //     }

        //     $file     = $request->file('complain_image');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('complain_images', $filename, 'public'); // Save to storage/app/public/complain_images
        //     $data['complain_image'] = $filename;
        // }


        /* -----------------------------
            Existing files from DB
        ----------------------------- */
        $existingFiles = json_decode($complain->complain_image, true) ?? [];

        /* -----------------------------
            REMOVE DELETED OLD FILES
        ----------------------------- */
        if ($request->removed_files) {
            $removedFiles = explode(',', $request->removed_files);

            foreach ($removedFiles as $file) {
                if (in_array($file, $existingFiles)) {
                    Storage::disk('public')->delete('complain_images/' . $file);
                    $existingFiles = array_diff($existingFiles, [$file]);
                }
            }
        }

        /* -----------------------------
            ADD NEW UPLOADED FILES
        ----------------------------- */
        if ($request->hasFile('complain_image')) {
            foreach ($request->file('complain_image') as $file) {
                // if ($file->isValid()) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('complain_images', $filename, 'public');
                $existingFiles[] = $filename;
                // }
            }
        }
        /***  Save files back as JSON ***/
        $data['complain_image'] = json_encode(array_values($existingFiles));

        $complain->update($data);
        return redirect()->route('complain.index')->with('success', 'Complain updated successfully.');
    }

    public function destroy(Complain $complain)
    {
        $complain = Complain::findOrFail($complain->id);
        if ($complain->complain_image) {
            Storage::disk('public')->delete('complain_images/' . $complain->complain_image);
        }

        $complain->delete();

        $complain_status_history = ComplainStatusHistory::where('complain_id', $complain->id);
        if ($complain_status_history) {
            $complain_status_history->delete();
        }
        return redirect()->route('complain.index')->with('success', 'Complain deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids) && is_array($ids)) {
            $complains = Complain::whereIn('id', $ids)->get();

            foreach ($complains as $complain) {

                $complain_status_history = ComplainStatusHistory::where('complain_id', $complain->id);
                if ($complain_status_history) {
                    $complain_status_history->delete();
                }

                if ($complain->complain_image) {
                    Storage::disk('public')->delete('complain_images/' . $complain->complain_image);
                }
                $complain->delete();
            }
            return response()->json(['message' => 'Selected Complains deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }
}
