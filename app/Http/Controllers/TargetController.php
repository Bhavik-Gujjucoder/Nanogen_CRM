<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\TargetGrade;
use Illuminate\Http\Request;
use App\Models\CityManagement;
use App\Models\GradeManagement;
use Yajra\DataTables\DataTables;
use App\Models\SalesPersonDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Target';
        if ($request->ajax()) {
            $records = Target::query();

            // Apply salesman filter if user has sales role
            if (auth()->user()->hasRole('sales')) {
                $records->where('salesman_id', auth()->id());
            }
            // dd($request->salemn_id);
            $records->when($request->salemn_id, function ($query) use ($request) {
                $query->where('salesman_id', $request->salemn_id);
            });
            $records->when($request->start_date && $request->end_date, function ($sub) use ($request) {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
                $sub->whereBetween('start_date', [$startDate, $endDate]);
                // ->orWhereBetween('end_date', [$startDate, $endDate]); 
            });

           



            return DataTables::of($records)
            // return DataTables::of(collect($records)) // ✅ wrap in collect()
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item target_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $show_btn = '<a href="' . route('target.show', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-eye text-warning"></i> Show Target</a>';



                    $edit_btn = '<a href="' . route('target.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteTarget"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('target.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage orders') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage orders') ? $action_btn .= $delete_btn : '';

                    $action_btn .= Auth::user()->hasAnyRole(['sales']) ? $show_btn : $edit_btn;
                    $action_btn .= $delete_btn;

                    return $action_btn . ' </div></div>';
                })
                ->addColumn('subject_name', function ($row) {
                    if ($row->subject) {
                        $target_name = $row->subject ?? '-';
                        $url = route('target.edit', $row->id);
                        return '<a href="' . $url . '">' . e($target_name) . '</a>';
                    }
                    return '-';
                })
                ->addColumn('target_result', function ($row) { // 🟨 Add this new column
                    if ($row->target_result === 'Win') {
                        return '<span class="badge bg-success">Win</span>';
                    } else {
                        return '<span class="badge bg-danger">Lost</span>';
                    }
                })
                ->editColumn('start_date', function ($row) {
                    return $row->start_date->format('d M Y');
                })
                ->editColumn('target_value', function ($row) {
                    if ($row->target_value) {
                        return IndianNumberFormat($row->target_value);
                    }
                    return '-';
                })
                ->editColumn('end_date', function ($row) {
                    return $row->end_date->format('d M Y');
                })
                ->editColumn('salesman_id', function ($row) {
                    if ($row->sales_person_detail) {
                        return $row->sales_person_detail->first_name . ' ' . $row->sales_person_detail->last_name;
                    }
                    return '-';
                })
                ->editColumn('city_id', function ($row) {
                    if ($row->city) {
                        return $row->city->city_name;
                    }
                    return '-';
                })
                ->filterColumn('salesman_id', function ($query, $keyword) {
                    $query->whereHas('sales_person_detail', function ($q) use ($keyword) {
                        $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('city_id', function ($query, $keyword) {
                    $query->whereHas('city', function ($q) use ($keyword) {
                        $q->where('city_name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['checkbox', 'action', 'subject_name', 'target_result']) //'value',
                ->make(true);
        }
        return view('admin.target.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create Target';
        $data['salesmans'] = SalesPersonDetail::where('deleted_at', NULL)->get();
        $data['cities'] = CityManagement::whereNull('deleted_at')->where('status', 1)->get();
        $data['grade'] = GradeManagement::whereNull('deleted_at')->where('status', 1)->get();
        return view('admin.target.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $target = Target::create($request->only([
            'subject',
            'salesman_id',
            'city_id',
            'target_value',
            'start_date',
            'end_date'
        ]));
        $target->save();


        if ($request->has(['grade_id', 'percentage', 'percentage_value'])) {
            $grade_id = $request->input('grade_id');
            $percentage = $request->input('percentage');
            $percentage_value = $request->input('percentage_value');

            foreach ($grade_id as $key => $g) {
                if (isset($grade_id[$key]) && isset($percentage[$key]) && isset($percentage_value[$key])) {
                    TargetGrade::create([
                        'target_id'  => $target->id,
                        'grade_id'   => $grade_id[$key],
                        'percentage' => $percentage[$key],
                        'percentage_value' => $percentage_value[$key],
                    ]);
                }
            }
        }

        try {
            if($request->salesman_id)
            {
                $admin_email = getSetting('company_email');
                if($admin_email)
                {
                    $id = $target->id;
                    $target = [];
                    $target = Target::with(['sales_person_detail'])->findOrFail($id);
                    $target->admin_email = 'for_admin_email';
                    Mail::send('email.target_email.target_create', compact('target'), fn($message) => $message->to($admin_email)->subject('Target has been set'));
                }

                $sales_person_email = $target->sales_person_detail->user->email;
                if($sales_person_email) {
                    $id = $target->id;
                    $target = [];
                    $target = Target::with(['sales_person_detail'])->findOrFail($id);
                    Mail::send('email.target_email.target_create', compact('target'), fn($message) => $message->to($sales_person_email)->subject('Target has been set'));
                }
            }
        }
        catch (\Throwable $th) {
            dd($th);
        }

        return redirect()->route('target.index')->with('success', 'Target created successfully.');
    }

    public function Show(string $id)
    {
        $data['page_title'] = 'Show Target';
        $data['target'] = Target::findOrFail($id);
        $data['salesmans'] = SalesPersonDetail::where('deleted_at', NULL)->get();
        $data['cities'] = CityManagement::whereNull('deleted_at')->where('status', 1)->get();
        $data['grade'] = GradeManagement::whereNull('deleted_at')->where('status', 1)->get();
        return view('admin.target.show', $data);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['page_title'] = 'Edit Target';
        $data['target'] = Target::findOrFail($id);
        $data['salesmans'] = SalesPersonDetail::where('deleted_at', NULL)->get();
        $data['cities'] = CityManagement::whereNull('deleted_at')->where('status', 1)->get();
        $data['grade'] = GradeManagement::whereNull('deleted_at')->where('status', 1)->get();
        return view('admin.target.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $target = Target::findOrFail($id);
        $target->update($request->only([
            'subject',
            'salesman_id',
            'city_id',
            'target_value',
            'start_date',
            'end_date'
        ]));

        if ($request->only(['grade_id', 'percentage', 'percentage_value'])) {

            TargetGrade::where('target_id', $id)->delete();

            $grade_id         = $request->input('grade_id');
            $percentage       = $request->input('percentage');
            $percentage_value = $request->input('percentage_value');

            if ($grade_id) {

                foreach ($grade_id as $key => $g) {
                    if (isset($grade_id[$key]) && isset($percentage[$key]) && isset($percentage_value[$key])) {
                        TargetGrade::create([
                            'target_id' => $target->id,
                            'grade_id' => $g,
                            'percentage' => $percentage[$key],
                            'percentage_value' => $percentage_value[$key],
                        ]);
                    }
                }
            }
        }
        return redirect()->route('target.index')->with('success', 'Target updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Target::where('id', $id)->delete();
        TargetGrade::where('target_id', $id)->delete();
        return redirect()->route('target.index')->with('success', 'Target deleted successfully.');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Target::whereIn('id', $ids)->delete();
            TargetGrade::whereIn('target_id', $ids)->delete();

            return response()->json(['message' => 'Selected Target deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }
}
