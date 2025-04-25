<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Complain;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\DistributorsDealers;
use Illuminate\Support\Facades\Auth;

class ComplainController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Complain';
        if ($request->ajax()) {
            $data = Complain::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item grade_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                
                    $edit_btn = '<a href="#" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="#" class="dropdown-item deleteGrade"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('grade.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-'. $row->id.'" >'
                        . csrf_field() . method_field('DELETE') . '</form>';


                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';
                    // Check if logged-in user is ID 1
                    // // Show edit button for all users
                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // // Show delete button if the user is not ID 1
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    return $action_btn . ' </div></div>';
                })
                ->editColumn('name', function ($row) {
                    $complainimage = isset($row->complain_image)
                        ? asset('storage/complain_images/' . $row->complain_image)
                        : asset('images/default-user.png');
                
                    $userLabel = $row->distributorsDealers?->user_type == 1
                        ? '(Distributor)'
                        : ($row->distributorsDealers?->user_type == 2 ? '(Dealer)' : '');
                
                    return '
                    <a href="' . $complainimage . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                        <img src="' . $complainimage . '" alt="Complain Image">
                    </a>
                    <span>' . ($row->distributorsDealers?->applicant_name ?? 'N/A') . '</span><br>
                    <small>' . $userLabel . '</small>';
                    
                })
                ->filterColumn('dd_id', function ($query, $keyword) {
                    $query->whereHas('distributorsDealers', function ($q) use ($keyword) {
                        $q->where('applicant_name', 'like', "%{$keyword}%")
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
                    return $row->product->product_name;
                })
                ->filterColumn('product_id', function ($query, $keyword) {
                    $query->whereHas('product', function ($q) use ($keyword) {
                        $q->where('product_name', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('status', function ($complain) {
                    return $complain->statusBadge(); // Get user roles
                })
                ->rawColumns(['checkbox', 'action', 'status', 'name'])
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
        $request->validate([
            'complain_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'complain_image.required' => 'Complain image is required.',
            'complain_image.image' => 'Complain image must be an image.',
            'complain_image.mimes' => 'Complain image must be a file of type: jpeg, png, jpg, gif.',
            'complain_image.max' => 'Complain image may not be greater than 2MB',
        ]);

        $data = [
            'dd_id' => $request->dd_id,
            'date' => $request->date,
            'product_id' => $request->product_id,
            'status' => $request->status,
            'description' => $request->description,
            'remark' => $request->remark,
        ];

        if ($request->hasFile('complain_image')) {
            $file     = $request->file('complain_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('complain_images', $filename, 'public'); // Save to storage/app/public/complain_images
            $data['complain_image'] = $filename;
        }else{
            $data['complain_image'] = null;
        }

        Complain::create($data);
        return redirect()->route('complain.index')->with('success', 'Complain created successfully.');
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Complain';
        $data['dds'] = DistributorsDealers::get();
        $data['products'] = Product::where('status', 1)->get();
        $data['complain'] = Complain::findOrFail($id);
        return view('admin.complain.edit', $data);
    }
}
