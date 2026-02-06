<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\TargetGrade;
use Illuminate\Http\Request;
use App\Models\CityManagement;
use Illuminate\Support\Carbon;
use App\Models\GradeManagement;
use App\Models\TargetQuarterly;
use Yajra\DataTables\DataTables;
use App\Models\SalesPersonDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderManagementProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TargetExport;


class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Target';

        $login_user_id = Auth::user()->id;
        $userIds = SalesPersonDetail::where('user_id', $login_user_id)
            ->pluck('reporting_sales_person_id');
        // ->push($login_user_id);
        $data['reporting_user_count'] = SalesPersonDetail::whereIn('user_id', $userIds)->count();

        if ($request->ajax()) {
            $records = Target::query();

            $quarterly = [
                1 => [Carbon::create(date('Y'), 1, 1), Carbon::create(date('Y'), 3, 31)],
                2 => [Carbon::create(date('Y'), 4, 1), Carbon::create(date('Y'), 6, 30)],
                3 => [Carbon::create(date('Y'), 7, 1), Carbon::create(date('Y'), 9, 30)],
                4 => [Carbon::create(date('Y'), 10, 1), Carbon::create(date('Y'), 12, 31)],
            ];

            /* Filter by Quarter */
            /* $records->when($request->quarterly, function ($query) use ($request, $quarterly) {
                if (isset($quarterly[$request->quarterly])) {
                    [$startDate, $endDate] = $quarterly[$request->quarterly];
                    $query->whereBetween('created_at', [
                        $startDate->startOfDay(),
                        $endDate->endOfDay()
                    ]);
                }
             }); */

            $records->when($request->quarterly, function ($query) use ($request, $quarterly) {
                $query->wherehas('target_quarterly', function ($q) use ($request) {
                    $q->where('quarterly', $request->quarterly);
                });

                /* if (isset($quarterly[$request->quarterly])) {  
                     [$startDate, $endDate] = $quarterly[$request->quarterly];
                     $query->whereHas('target_quarterly', function ($q) use ($startDate, $endDate) {
                         $q->whereBetween('quarterly', [
                             $startDate->startOfDay(),
                             $endDate->endOfDay()
                         ]);
                     });
                 }*/
            });

            if (auth()->user()->hasRole('sales')) {
                $sales_user_ids = getSalesUserIds();
                if (!empty($sales_user_ids)) {
                    $records->whereIn('salesman_id', $sales_user_ids);
                }
            }

            if (auth()->user()->hasRole('reporting manager')) {
                $report_manager_sales_user_ids = getReportManagerSalesPersonId(); // 
                if (!empty($report_manager_sales_user_ids)) {
                    $records->whereIn('salesman_id', $report_manager_sales_user_ids);
                }
            }

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
                    // $action_btn .= Auth::user()->hasAnyRole(['sales']) ? $edit_btn : $edit_btn;
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
                ->addColumn('quarterly', function ($row) { // 🟨 Add this new column
                    return  $row->target_quarterly->map(function ($q) {
                        return '<span class="badge bg-gray me-1 mb-1">
                                    Quarterly ' . e($q->quarterly) . ' ⮚ ' . e($q->quarterly_percentage) . '% 
                                </span>';
                    })->implode('<br>');
                })
                /* ->editColumn('start_date', function ($row) {
                     return $row->start_date->format('d M Y');
                }) */
                ->editColumn('target_value', function ($row) {
                    if ($row->target_value) {
                        return IndianNumberFormat($row->target_value);
                    }
                    return '-';
                })
                /* ->editColumn('end_date', function ($row) {
                     return $row->end_date->format('d M Y');
                })*/
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M Y');
                })
                // ->editColumn('salesman_id', function ($row) {
                //     if ($row->sales_person_detail) {
                //         return $row->sales_person_detail->first_name . ' ' . $row->sales_person_detail->last_name;
                //     }
                //     return '-';
                // })
                ->editColumn('salesman_id', function ($row) {
                    $order_id = $row->sales_person_detail;
                    return '<a href="' . route('target.show', $row->id) . '" class="show-btn open-popup-model"  data-id="' . $row->id . '">
                                <i class="ti ti-eye #1ecbe2"></i>  ' . $row->sales_person_detail?->first_name ?? '' . ' ' . $row->sales_person_detail?->last_name ?? '' . '</a>';
                })
                ->editColumn('city_id', function ($row) {
                    if ($row->city) {
                        return $row->city->city_name;
                    }
                    return '-';
                })
                ->editColumn('qurterly_1', function ($row) {
                    $data = $row->target_quarterly->where('quarterly', 1);
                    return $data->isNotEmpty()
                        ? $data->map(function ($q) {
                            return '<span class="badge bg-gray me-1 mb-1">
                        ₹' . number_format($q->quarterly_target_value, 0) . '
                    </span>';
                        })->implode('<br>')
                        : '-';
                })
                ->editColumn('qurterly_2', function ($row) {
                    $data = $row->target_quarterly->where('quarterly', 2);
                    return $data->isNotEmpty()
                        ? $data->map(function ($q) {
                            return '<span class="badge bg-gray me-1 mb-1">
                        ₹' . number_format($q->quarterly_target_value, 0) . '
                    </span>';
                        })->implode('<br>')
                        : '-';
                })
                ->editColumn('qurterly_3', function ($row) {
                    $data = $row->target_quarterly->where('quarterly', 3);
                    return $data->isNotEmpty()
                        ? $data->map(function ($q) {
                            return '<span class="badge bg-gray me-1 mb-1">
                        ₹' . number_format($q->quarterly_target_value, 0) . '
                    </span>';
                        })->implode('<br>')
                        : '-';
                })
                ->editColumn('qurterly_4', function ($row) {
                    $data = $row->target_quarterly->where('quarterly', 4);
                    return $data->isNotEmpty()
                        ? $data->map(function ($q) {
                            return '<span class="badge bg-gray me-1 mb-1">
                        ₹' . number_format($q->quarterly_target_value, 0) . '
                    </span>';
                        })->implode('<br>')
                        : '-';
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
                ->filterColumn('qurterly_1', fn() => null)
                ->filterColumn('qurterly_2', fn() => null)
                ->filterColumn('qurterly_3', fn() => null)
                ->filterColumn('qurterly_4', fn() => null)
                ->rawColumns(['checkbox', 'action', 'subject_name', 'target_result', 'quarterly', 'qurterly_1', 'qurterly_2', 'qurterly_3', 'qurterly_4', 'salesman_id']) //'value',
                ->make(true);
        }
        return view('admin.target.index', $data);
    }

    public function target_view($id)
    {
        try {
            $data['target'] = Target::findOrFail($id);
            $data['salesmans'] = SalesPersonDetail::where('deleted_at', NULL)->get();
            $data['cities'] = CityManagement::whereNull('deleted_at')->where('status', 1)->get();
            $data['grade'] = GradeManagement::whereNull('deleted_at')->where('status', 1)->get();

            $html = view('admin.target.view', $data)->render(); // Assuming your modal HTML is in target.modal view.

            return response()->json([
                'html' => $html,  // Return the modal HTML as a string
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'Something went wrong!'], 500);
            // return redirect()->back()->with('error', 'Something is wrong!!');
        }
    }

    /**
     * Display listing of target wise all quarter
     */
    public function target_quarterly(Request $request)
    {
        $data['page_title'] = 'Target';
        if ($request->ajax()) {
            $records = Target::query();

            if (auth()->user()->hasRole('sales')) {
                $sales_user_ids = getSalesUserIds();
                if (!empty($sales_user_ids)) {
                    $records->whereIn('salesman_id', $sales_user_ids);
                }
            }

            if (auth()->user()->hasRole('reporting manager')) {
                $report_manager_sales_user_ids = getReportManagerSalesPersonId();
                if (!empty($report_manager_sales_user_ids)) {
                    $records->whereIn('salesman_id', $report_manager_sales_user_ids);
                }
            }

            $records->when($request->salemn_id, function ($query) use ($request) {
                $query->where('salesman_id', $request->salemn_id);
            });

            $dates = [
                1 => [date('Y-01-01'), date('Y-03-31')],
                2 => [date('Y-04-01'), date('Y-06-30')],
                3 => [date('Y-07-01'), date('Y-09-30')],
                4 => [date('Y-10-01'), date('Y-12-31')],
                // 2 => ['01-04-Y', '30-06-Y'],
                // 3 => ['01-07-Y', '30-09-Y'],
                // 4 => ['01-10-Y', '31-12-Y'],
            ];


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



                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    $action_btn .= Auth::user()->hasAnyRole(['sales']) ? $show_btn : $edit_btn;

                    return $action_btn . ' </div></div>';
                })
                ->addColumn('quarter_name', function ($row) {
                    if ($row->subject) {
                        $target_name = $row->subject ?? '-';
                        $url = route('target.edit', $row->id);
                        if ($row->target_quarterly->count() > 0) {
                            // Loop through quarters and attach target name
                            $quarters = $row->target_quarterly->map(function ($q) use ($target_name, $url) {
                                return '<a href="' . $url . '">' . e($target_name) . '</a><small> <span class="badge bg-gray me-1 mb-1">'
                                    . ' ⮚ Quarterly ' . e($q->quarterly)
                                    . ' (' . e($q->quarterly_percentage) . '%)</span></small>';
                            })->implode('<br>');

                            return $quarters;
                        }

                        return '<a href="' . $url . '"><b>' . e($target_name);
                    }
                    return '-';
                })
                ->addColumn('quarterly_target_value', function ($row) {
                    if ($row->target_quarterly->count() > 0) {
                        return $row->target_quarterly->map(function ($q) {
                            return ' ₹' . number_format($q->quarterly_target_value, 0);
                        })->implode('<br>');
                    }
                    return '-';
                })
                ->addColumn('achived_quarter', function ($row) use ($request, $dates) {
                    if ($row->target_quarterly->count() > 0) {
                        return $row->target_quarterly->map(function ($q) use ($request, $dates) {
                            // dd($q);
                            $gradeIds = $q->target_grade()->pluck('grade_id');
                            $totalAmount = OrderManagementProduct::whereHas('order', function ($query) use ($dates, $q, $request) {
                                $query->where('salesman_id', $request->salemn_id)
                                    ->whereBetween('order_date', $dates[$q->quarterly]);
                            })
                                ->whereHas('product', function ($query) use ($gradeIds) {
                                    $query->whereIn('grade_id', $gradeIds);
                                })
                                ->sum('total');
                            return
                                ' ₹' . number_format($totalAmount, 0);
                        })->implode('<br>');
                    }
                    return '-';
                })
                ->addColumn('win_loss', function ($row) use ($request, $dates) {
                    if ($row->target_quarterly->count() > 0) {
                        return $row->target_quarterly->map(function ($q) use ($request, $dates) {
                            // dd($q);
                            $gradeIds = $q->target_grade()->pluck('grade_id');
                            $totalAmount = OrderManagementProduct::whereHas('order', function ($query) use ($dates, $q, $request) {
                                $query->where('salesman_id', $request->salemn_id)
                                    ->whereBetween('order_date', $dates[$q->quarterly]);
                            })
                                ->whereHas('product', function ($query) use ($gradeIds) {
                                    $query->whereIn('grade_id', $gradeIds);
                                })
                                ->sum('total');
                            // return ($totalAmount >= $q->quarterly_target_value) ? 'Win' : 'Loss';

                            if ($totalAmount >= $q->quarterly_target_value) {
                                return '<button class="win-btn btn">Win</button>';
                            } else {
                                return '<button class="loss-btn btn">Loss</button>';
                            }
                        })->implode(''); //<br>
                    }
                    return '-';
                })
                ->addColumn('quarterly', function ($row) { // Add this new column
                    return  $row->target_quarterly->map(function ($q) {
                        return '<span class="badge bg-gray me-1 mb-1">
                                    Quarterly ' . e($q->quarterly) . ' ⮚ ' . e($q->quarterly_percentage) . '% 
                                </span>';
                    })->implode('<br>');
                })
                /* target value */
                // ->editColumn('target_value', function ($row) {
                //     if ($row->target_value) {
                //         return IndianNumberFormat($row->target_value);
                //     }
                //     return '-';
                // })


                ->editColumn('salesman_id', function ($row) {
                    if ($row->sales_person_detail) {
                        return $row->sales_person_detail?->first_name . ' ' . $row->sales_person_detail?->last_name;
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
                ->rawColumns(['checkbox', 'action', 'quarter_name', 'quarterly_target_value', 'target_result', 'win_loss', 'achived_quarter', 'quarterly']) //'value',
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

        $login_user_id = Auth::user()->id;
        $userIds = SalesPersonDetail::where('user_id', $login_user_id)
            ->pluck('reporting_sales_person_id');
        // ->push($login_user_id);

        $data['reportingUserId'] = SalesPersonDetail::whereIn('user_id', $userIds)->get();
        // dd($data['reportingUserId']->count());
        return view('admin.target.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $target = Target::create($request->only([
    //         'subject',
    //         'salesman_id',
    //         'city_id',
    //         'target_value',
    //         'start_date',
    //         'end_date'
    //     ]));
    //     $target->save();

    //     if ($request->has(['grade_id', 'percentage', 'percentage_value'])) {
    //         $grade_id = $request->input('grade_id');
    //         $percentage = $request->input('percentage');
    //         $percentage_value = $request->input('percentage_value');

    //         foreach ($grade_id as $key => $g) {
    //             if (isset($grade_id[$key]) && isset($percentage[$key]) && isset($percentage_value[$key])) {
    //                 TargetGrade::create([
    //                     'target_id'  => $target->id,
    //                     'grade_id'   => $grade_id[$key],
    //                     'percentage' => $percentage[$key],
    //                     'percentage_value' => $percentage_value[$key],
    //                 ]);
    //             }
    //         }
    //     }

    //     try {
    //         if($request->salesman_id)
    //         {
    //             $admin_email = getSetting('company_email');
    //             if($admin_email)
    //             {
    //                 $id = $target->id;
    //                 $target = [];
    //                 $target = Target::with(['sales_person_detail'])->findOrFail($id);
    //                 $target->admin_email = 'for_admin_email';
    //                 Mail::send('email.target_email.target_create', compact('target'), fn($message) => $message->to($admin_email)->subject('Target has been set'));
    //             }

    //             $sales_person_email = $target->sales_person_detail->user->email;
    //             if($sales_person_email) {
    //                 $id = $target->id;
    //                 $target = [];
    //                 $target = Target::with(['sales_person_detail'])->findOrFail($id);
    //                 Mail::send('email.target_email.target_create', compact('target'), fn($message) => $message->to($sales_person_email)->subject('Target has been set'));
    //             }
    //         }
    //     }
    //     catch (\Throwable $th) {
    //         dd($th);
    //     }

    //     return redirect()->route('target.index')->with('success', 'Target created successfully.');
    // }

    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // 1. Create Target
            $target = Target::create($request->only([
                'subject',
                'salesman_id',
                'city_id',
                'target_value',
            ]));

            // 2. Loop Quarterly Data
            foreach ($request->quarterly as $qIndex => $quarterVal) {
                $quarter = TargetQuarterly::create([
                    'target_id' => $target->id,
                    'quarterly' => $quarterVal,
                    'quarterly_percentage' => $request->quarterly_percentage[$qIndex],
                    'quarterly_target_value' => preg_replace('/[^\d.]/', '', $request->quarterly_target_value[$qIndex]),
                ]);

                // 3. Loop Grade Data for this Quarter
                if (isset($request->grade_id[$qIndex])) {
                    foreach ($request->grade_id[$qIndex] as $gIndex => $gradeVal) {
                        TargetGrade::create([
                            'target_id' => $target->id,
                            'target_quarterly_id' => $quarter->id,
                            'grade_id' => $gradeVal,
                            'grade_percentage' => $request->grade_percentage[$qIndex][$gIndex],
                            'grade_target_value' => preg_replace('/[^\d.]/', '', $request->grade_target_value[$qIndex][$gIndex]),
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('target.index')->with('success', 'Target created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
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

        $login_user_id = Auth::user()->id;
        $userIds = SalesPersonDetail::where('user_id', $login_user_id)
            ->pluck('reporting_sales_person_id')
            ->push($login_user_id);
        // dd($userIds);
        $data['reportingUserId'] = SalesPersonDetail::whereIn('user_id', $userIds)->get();

        return view('admin.target.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $target = Target::findOrFail($id);
    //     $target->update($request->only([
    //         'subject',
    //         'salesman_id',
    //         'city_id',
    //         'target_value',
    //         'start_date',
    //         'end_date'
    //     ]));

    //     if ($request->only(['grade_id', 'percentage', 'percentage_value'])) {

    //         TargetGrade::where('target_id', $id)->delete();

    //         $grade_id         = $request->input('grade_id');
    //         $percentage       = $request->input('percentage');
    //         $percentage_value = $request->input('percentage_value');

    //         if ($grade_id) {

    //             foreach ($grade_id as $key => $g) {
    //                 if (isset($grade_id[$key]) && isset($percentage[$key]) && isset($percentage_value[$key])) {
    //                     TargetGrade::create([
    //                         'target_id' => $target->id,
    //                         'grade_id' => $g,
    //                         'percentage' => $percentage[$key],
    //                         'percentage_value' => $percentage_value[$key],
    //                     ]);
    //                 }
    //             }
    //         }
    //     }
    //     return redirect()->route('target.index')->with('success', 'Target updated successfully.');
    // }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $target = Target::findOrFail($id);
            // update target
            $target->update($request->only(['subject', 'salesman_id', 'city_id', 'target_value']));

            // delete old quarters & grades
            TargetQuarterly::where('target_id', $target->id)->delete();
            TargetGrade::where('target_id', $target->id)->delete();

            // insert new quarters & grades
            foreach ($request->quarterly as $q => $quarterVal) {
                $quarter = TargetQuarterly::create([
                    'target_id' => $target->id,
                    'quarterly' => $quarterVal,
                    'quarterly_percentage' => $request->quarterly_percentage[$q],
                    'quarterly_target_value' => preg_replace('/[^\d.]/', '', $request->quarterly_target_value[$q]),
                ]);

                if (isset($request->grade_id[$q])) {
                    foreach ($request->grade_id[$q] as $g => $gradeVal) {
                        TargetGrade::create([
                            'target_id' => $target->id,
                            'target_quarterly_id' => $quarter->id,
                            'grade_id' => $gradeVal,
                            'grade_percentage' => $request->grade_percentage[$q][$g],
                            'grade_target_value' => preg_replace('/[^\d.]/', '', $request->grade_target_value[$q][$g]),
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('target.index')->with('success', 'Target updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
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

    public function export(Request $request, $quarterly = null)
    {
        $records = Target::query();
        //  dd($records->get());
        $quarterly = [
            1 => [Carbon::create(date('Y'), 1, 1), Carbon::create(date('Y'), 3, 31)],
            2 => [Carbon::create(date('Y'), 4, 1), Carbon::create(date('Y'), 6, 30)],
            3 => [Carbon::create(date('Y'), 7, 1), Carbon::create(date('Y'), 9, 30)],
            4 => [Carbon::create(date('Y'), 10, 1), Carbon::create(date('Y'), 12, 31)],
        ];

        /* Filter by Quarter */
        $records->when($request->quarterly, function ($query) use ($request, $quarterly) {
            $query->wherehas('target_quarterly', function ($q) use ($request) {
                $q->where('quarterly', $request->quarterly);
            });
        });
        // $records->when($request->quarterly, function ($query) use ($request, $quarterly) {
        //     if (isset($quarterly[$request->quarterly])) {
        //         [$startDate, $endDate] = $quarterly[$request->quarterly];
        //         $query->whereBetween('created_at', [
        //             $startDate->startOfDay(),
        //             $endDate->endOfDay()
        //         ]);
        //     }
        // });

        /*** 'Reporting Salesperson' is displayed for Salesperson login ***/
        if (auth()->user()->hasRole('sales')) {
            $sales_user_ids = getSalesUserIds();
            if (!empty($sales_user_ids)) {
                $records->whereIn('salesman_id', $sales_user_ids);
            }
        }
        /* END */

        if (auth()->user()->hasRole('reporting manager')) {
            $report_manager_sales_user_ids = getReportManagerSalesPersonId();
            if (!empty($report_manager_sales_user_ids)) {
                $records->whereIn('salesman_id', $report_manager_sales_user_ids);
            }
        }

        $data = $records->get();
        return Excel::download(new TargetExport($data), 'Target_quarter-' . $request->quarterly . '.xlsx');
    }
}
