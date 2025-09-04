<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\CityManagement;
use App\Models\StateManagement;
use Yajra\DataTables\DataTables;
use App\Models\SalesPersonDetail;
use Illuminate\Support\Facades\DB;
use App\Models\SalesPersonPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\SalesPersonDepartment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\OrderManagement;
use App\Models\Target;
use App\Models\OrderManagementProduct;
use Carbon\CarbonPeriod;


class SalesPersonController extends Controller
{
    protected $order_management, $target, $sales_person_detail;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderManagement $order_management,
        Target $target,
        SalesPersonDetail $sales_person_detail,

    ) {
        $this->order_management = $order_management;
        $this->target = $target;
        $this->sales_person_detail = $sales_person_detail;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Sales Person';

        if ($request->ajax()) {
            $data = SalesPersonDetail::with('user');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item sales_person_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="' . route('sales_person.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $sales_report_btn = '<a href="' . route('sales_person.sales_report', $row->user_id) . '" class="dropdown-item"  data-id="' . $row->user_id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-eye text-warning"></i>Sales Report</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteSalesPerson"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('sales_person.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage sales') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage sales') ? $action_btn .= $delete_btn : '';
                    $action_btn .= Auth::user()->hasAnyRole(['super admin', 'admin']) ? $sales_report_btn : '';
                    // $action_btn .= $sales_report_btn;
                    $action_btn .= $edit_btn;
                    $action_btn .= $delete_btn;
                    return $action_btn . ' </div></div>';
                })
                ->editColumn('first_name', function ($row) {
                    $user = $row->user;
                    $profilePic = $user && !empty($user->profile_picture)
                        ? asset("storage/profile_pictures/" . $user->profile_picture)
                        : asset("images/default-user.png");
                    $name = $row->first_name . ' ' . $row->last_name;

                    if ($user) {
                        return '<a href="' . $profilePic . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                                    <img class="" src="' . $profilePic . '" alt="User Image">
                                </a>' . $name;
                    }
                    return $name;
                })

                ->editColumn('user.phone_no', function ($row) {
                    return $row->user ? $row->user->phone_no : '-';
                })
                // ->editColumn('reporting_manager_id', function ($row) {
                //     return $row->reporting_manager ? $row->reporting_manager->name : '-';
                // })

                ->editColumn('user.email', function ($row) {
                    return $row->user ? $row->user->email : '-';
                })
                ->filterColumn('first_name', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('first_name', 'like', "%{$keyword}%")
                            ->orWhere('last_name', 'like', "%{$keyword}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
                    });
                })
                ->rawColumns(['checkbox', 'action', 'first_name'])
                ->make(true);
        }
        return view('admin.sales_person.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title']         = 'Basic Information';
        $data['reporting_managers'] = User::role(['reporting manager'])->where('status', 1)->get();
        $data['departments']        = SalesPersonDepartment::where('status', 1)->get()->all();
        $data['positions']          = SalesPersonPosition::where('status', 1)->get()->all();
        $data['states']             = StateManagement::where('status', 1)->get()->all();
        $data['cities']             = CityManagement::where('status', 1)->get()->all();
        $data['countries']          = Country::where('status', 1)->get()->all();

        $latest_employee_id = SalesPersonDetail::withTrashed()->max('id');
        $nextId             = $latest_employee_id ? $latest_employee_id + 1 : 1;
        $data['employeeId'] = 'ES' . str_pad($nextId, max(6, strlen($nextId)), '0', STR_PAD_LEFT);

        return view('admin.sales_person.create', $data);
    }


    /***  AJAX to fetch cities by state ID  ***/
    public function getCitiesByState(Request $request)
    {
        $cities = CityManagement::where('state_id', $request->state_id)->where('status', 1)->get();
        return response()->json($cities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_picture'      => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2048',
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'phone_number'         => 'required|numeric|digits_between:10,15|unique:users,phone_no,NULL,id,deleted_at,NULL',
            'password'             => 'required|string|min:6|confirmed',     /*use password_confirmation field too*/
            // 'employee_id'          => 'required|string|max:255|unique:sales_person_details,employee_id,NULL,id,deleted_at,NULL',
            'department_id'        => 'required|exists:sales_person_department,id',
            'position_id'          => 'required|exists:sales_person_position,id',
            'reporting_manager_id' => 'required',
            'date'                 => 'required|date_format:d-m-Y',
            'street_address'       => 'required|string|max:255',
            // 'city_id'              => 'required|exists:city_management,id',
            'city_ids'             => 'required|exists:city_management,id',
            'state_id'             => 'required|exists:state_management,id',
            'postal_code'          => 'required|string|max:10',
            'country_id'           => 'required|exists:countries,id',
        ], [
            'department_id.required'        => 'The department field is required.',
            'position_id.required'          => 'The position field is required.',
            'reporting_manager_id.required' => 'The reporting manager field is required.',
            // 'city_id.required'              => 'The city field is required.',
            'city_ids.required'             => 'The area of operation field is required.',
            'state_id.required'             => 'The state field is required.',
            'country_id.required'           => 'The country field is required.',
        ]);

        DB::beginTransaction();
        try {
            $user = new User();
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('profile_pictures', $filename, 'public'); // Save to storage/app/public/profile_pictures
                $user->profile_picture = $filename;
            }

            $user->name     = $request->first_name . ' ' . $request->last_name;
            $user->email    = $request->email;
            $user->phone_no = $request->phone_number;
            $user->password = Hash::make($request->password);
            $user->save();

            $latest_employee_id = SalesPersonDetail::withTrashed()->max('id');
            $nextId             = $latest_employee_id ? $latest_employee_id + 1 : 1;
            $employee_id        = 'ES' . str_pad($nextId, max(6, strlen($nextId)), '0', STR_PAD_LEFT);

            $cityIds = implode(',', $request->city_ids);

            /* Store into sales_person_details table */
            $salesDetail = new SalesPersonDetail();
            $salesDetail->first_name           = $request->first_name;
            $salesDetail->last_name            = $request->last_name;
            $salesDetail->user_id              = $user->id;
            $salesDetail->employee_id          = $employee_id;
            $salesDetail->department_id        = $request->department_id;
            $salesDetail->position_id          = $request->position_id;
            $salesDetail->reporting_manager_id = $request->reporting_manager_id;
            $salesDetail->date                 = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $salesDetail->street_address       = $request->street_address;
            $salesDetail->city_id              = $request->city_id ?? null;
            $salesDetail->state_id             = $request->state_id;
            $salesDetail->city_ids             = $cityIds;
            $salesDetail->postal_code          = $request->postal_code;
            $salesDetail->country_id           = $request->country_id;
            $salesDetail->save();

            $data = [
                'name'  => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
            ];
            if ($request->email) {
                Mail::send('email.sales_person_email.create', ['data' => $data], fn($message) => $message->to($request->email)->subject('Sales Person Account Created'));
            }
            $user->assignRole('sales');
            DB::commit();
            return redirect()->route('sales_person.index')->with('success', 'Sales person created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['page_title']         = 'Edit Basic Information';
        $data['detail']             = SalesPersonDetail::findOrFail($id);
        $data['reporting_managers'] = User::role(['reporting manager'])->where('status', 1)->get();
        $data['departments']        = SalesPersonDepartment::where('status', 1)->get()->all();
        $data['positions']          = SalesPersonPosition::where('status', 1)->get()->all();
        $data['countries']          = Country::where('status', 1)->get()->all();
        $data['states']             = StateManagement::where('status', 1)->get()->all();
        $data['cities']             = CityManagement::where('status', 1)->get()->all();

        return view('admin.sales_person.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $salesDetail = SalesPersonDetail::findOrFail($id);
        $user        = User::where('id', $salesDetail->user_id)->first();
        $request->validate([
            'profile_picture'      => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2048',
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email,' . $user->id . ',id,deleted_at,NULL',
            'phone_number'         => 'required|numeric|digits_between:10,15|unique:users,phone_no,' . $user->id . ',id,deleted_at,NULL',
            'password'             => 'nullable|string|min:6|confirmed',   /* use password_confirmation field too */
            'department_id'        => 'required|exists:sales_person_department,id',
            'position_id'          => 'required|exists:sales_person_position,id',
            'reporting_manager_id' => 'required',
            'date'                 => 'required|date_format:d-m-Y',
            'street_address'       => 'required|string|max:255',
            // 'city_id'              => 'required|exists:city_management,id',
            'state_id'             => 'required|exists:state_management,id',
            'city_ids'             => 'required|exists:city_management,id',
            'postal_code'          => 'required|string|max:10',
            'country_id'           => 'required|exists:countries,id',
        ], [
            'department_id.required'        => 'The department field is required.',
            'position_id.required'          => 'The position field is required.',
            'reporting_manager_id.required' => 'The reporting manager field is required.',
            // 'city_id.required'              => 'The city field is required.',
            'city_ids.required'             => 'The area of operation field is required.',
            'state_id.required'             => 'The state field is required.',
            'country_id.required'           => 'The country field is required.',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name'     => $request->first_name . ' ' . $request->last_name,
                'email'    => $request->email,
                'phone_no' => $request->phone_number,
            ]);

            $user->assignRole('sales');
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture) {   /* Delete old profile picture if exists */
                    Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
                }
                /* Upload new profile picture */
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('profile_pictures', $filename, 'public'); /* Save in storage/app/public/profile_pictures */
                $user->profile_picture = $filename; /* Save new filename in database */
            }

            $user->save();

            $cityIds = implode(',', $request->city_ids);
            $salesDetail->first_name           = $request->first_name;
            $salesDetail->last_name            = $request->last_name;
            $salesDetail->department_id        = $request->department_id;
            $salesDetail->position_id          = $request->position_id;
            $salesDetail->reporting_manager_id = $request->reporting_manager_id;
            $salesDetail->date                 = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $salesDetail->street_address       = $request->street_address;
            $salesDetail->city_id              = $request->city_id ?? null;
            $salesDetail->state_id             = $request->state_id;
            $salesDetail->city_ids             = $cityIds;
            $salesDetail->postal_code          = $request->postal_code;
            $salesDetail->country_id           = $request->country_id;
            $salesDetail->save();

            DB::commit();
            return redirect()->route('sales_person.index')->with('success', 'Sales person updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = SalesPersonDetail::findOrFail($id);
        $user   = User::where('id', $detail->user_id)->first();

        if (isset($user->profile_picture)) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }
        if (!$user) {
            return redirect()->route('sales_person.index')->with('error', 'Sales person not found.');
        } else {
            $user->delete();
        }

        if (!$detail) {
            return redirect()->route('sales_person.index')->with('error', 'Sales person detail not found.');
        } else {
            $detail->delete();
        }

        return redirect()->route('sales_person.index')->with('success', 'Sales person deleted successfully.');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids) && is_array($ids)) {
            $details = SalesPersonDetail::whereIn('id', $ids)->get()->all();
            foreach ($details as $key => $detail) {
                $user = User::where('id', $detail->user_id)->first();
                if ($user->profile_picture) {
                    Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
                }
                $user->delete();
                $detail->delete();
            }
            return response()->json(['message' => 'Selected users deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }

    public function sales_report(Request $request)
    {
        $sales_person = $this->sales_person_detail->where('user_id', $request->id)->first();
        $sales_user   = $sales_person->user_id;
        $data['sales_user']        = $sales_user;
        $data['page_title']        = 'Sales Person Report of ' . $sales_person->first_name . ' ' . $sales_person->last_name;

        $order = $this->order_management->where('salesman_id', $sales_user);
        if ($request->start_date && $request->end_date) {
            $order = $order->whereBetween('order_date', [
                Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'),
                Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d')
            ]);
        }
        $data['total_order'] = $order->count();
        $data['order_grand_total'] = $order->sum('grand_total');

        $target = $this->target->where('salesman_id', $sales_user);
        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

            $target->where(function ($sub) use ($startDate, $endDate) {
                $sub->whereBetween('start_date', [$startDate, $endDate])
                    ->orwhereBetween('end_date', [$startDate, $endDate]);
            });
        }
        $targets = $target->get();
        $data['total_target']        = $targets->count();
        $data['total_target_amount'] = $targets->sum('target_value');

        // $data['total_order']       = $this->order_management->where('salesman_id', $sales_user)->count();
        // $data['order_grand_total'] = $this->order_management->where('salesman_id', $sales_user)->sum('grand_total');
        // $data['total_target']      = $this->target->where('salesman_id', $sales_user)->count();

        // if ($request->start_date && $request->end_date) {
        // $data['latest_orders'] = $this->order_management->where('salesman_id', $sales_user)
        //             ->where(function ($sub) use ($startDate, $endDate) {
        //                 $sub->whereBetween('order_date', [$startDate, $endDate]);
        //             })
        //         ->paginate(2)
        //         ->appends($request->only('start_date', 'end_date'));
        // } else {
        //    $data['latest_orders']     = $this->order_management->where('salesman_id', $sales_user)->latest()->take(5)->get();
        // }

        $data['latest_orders']     = $this->order_management->where('salesman_id', $sales_user)->latest()->take(5)->get();
        $data['latest_target']     = $this->target->where('salesman_id', $sales_user)->latest()->take(5)->get();

        $data['current_target']    = $this->target->with('target_grade')
            ->where('salesman_id', $sales_user)
            ->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
        $data['past_targets']      = $this->target->with('target_quarterly')
            ->where('salesman_id', $sales_user)
            // ->where('end_date', '<', Carbon::today())
            ->get();
        // dd( $data['past_targets']  );


        /***** Last 12 months order performance *****/
        if ($request->start_date && $request->end_date) {
            $startDateObj = Carbon::createFromFormat('d-m-Y', $request->start_date);
            $endDateObj = Carbon::createFromFormat('d-m-Y', $request->end_date);

            $monthCount = (int) ($startDateObj->diffInMonths($endDateObj) + 1);

            $data['order_chart_heading'] = "Last {$monthCount} Months Order Performance";
            $data['revenu_chart_heading'] = "Last {$monthCount} Months Revenue Performance";

            // Use string format for DB queries
            $startDate = $startDateObj->format('Y-m-d');
            $endDate = $endDateObj->format('Y-m-d');

            // $data['order_chart_heading'] = 'Order Performance';
            // $data['revenu_chart_heading'] = 'Revenu Performance';



        } else {
            $startDate = Carbon::now()->subMonths(12)->startOfMonth()->toDateString();
            $endDate   = Carbon::now()->endOfMonth()->toDateString();
            $data['order_chart_heading'] = 'Last 12 Months Order Performance';
            $data['revenu_chart_heading'] = 'Last 12 Months Revenu Performance';
        }

        $orders = $this->order_management
            ->select(
                DB::raw("DATE_FORMAT(order_date, '%b %Y') as month_year"),
                DB::raw("COUNT(*) as total")
            )
            ->where('salesman_id', $sales_user)
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy(DB::raw("DATE_FORMAT(order_date, '%b %Y')"))
            ->orderBy(DB::raw("MIN(order_date)")) // sorts properly
            ->get();

        // Generate last 12 months list (with year)
        // $months = collect(range(0, 11))->map(function ($i) {
        //     return Carbon::now()->subMonths(11 - $i)->format('M Y');
        // });
        $months = collect(CarbonPeriod::create($startDate, '1 month', $endDate))
            ->map(fn($date) => $date->format('M Y'));

        // Merge with DB results
        $order_chart = $months->map(function ($monthYear) use ($orders) {
            $order = $orders->firstWhere('month_year', $monthYear);
            return [
                'month' => $monthYear,
                'total' => $order ? (int) $order->total : 0,
            ];
        });
        $data['order_chart'] = $order_chart;
        /***** END *****/

        /***** Last 12 month Revenu performance *****/
        $orders = $this->order_management
            ->select(
                // DB::raw("DATE_FORMAT(order_date, '%b') as month"),
                DB::raw("DATE_FORMAT(order_date, '%b %Y') as month"),
                DB::raw("SUM(grand_total) as total")
            )
            ->where('salesman_id', $sales_user)
            ->whereBetween('order_date', [$startDate, $endDate])
            // ->groupBy(DB::raw("DATE_FORMAT(order_date, '%b')"))
            // ->orderBy(DB::raw("STR_TO_DATE(DATE_FORMAT(order_date, '%b'), '%b')"))

            ->groupBy(DB::raw("DATE_FORMAT(order_date, '%b %Y')"))
            ->orderBy(DB::raw("MIN(order_date)"))
            ->get();

        // Prepare chart data (fill missing months if needed)
        // $months = collect(range(0, 11))->map(function ($i) {
        //     return Carbon::now()->subMonths(11 - $i)->format('M Y');
        // });

        $revenue_chart = $months->map(function ($month) use ($orders) {
            $order = $orders->firstWhere('month', $month);
            return [
                'month' => $month,
                'total' =>  $order ? (float) $order->total : 0, //(float)
            ];
        });

        $data['revenue_chart'] = $revenue_chart;
        /***** END *****/


        /***** Running Target *****/
        $cTargets = [];
        foreach ($data['current_target'] as $key => $target) {
            $grades = [];
            foreach ($target->target_grade as $target_grade) {
                $gradeId = $target_grade->grade_id;

                $totalAmount = OrderManagementProduct::whereHas('order', function ($q) use ($sales_user, $target) {
                    $q->where('salesman_id', $sales_user)
                        ->whereBetween('order_date', [$target->start_date, $target->end_date]);
                })
                    ->whereHas('product', function ($q) use ($gradeId) {
                        $q->where('grade_id', $gradeId);
                    })
                    ->sum('total'); // Replace with calculation if needed: ->selectRaw('SUM(price * quantity)') if not a single 'amount'
                $grades[] = [
                    'grade_id' => $target_grade->grade->name,
                    'percentage' => $totalAmount,
                    'percentage_value' => $target_grade->percentage_value,
                    'achieved_percentage' => round(($target_grade->percentage_value > 0 ? ($totalAmount / $target_grade->percentage_value) * 100 : 0), 2)
                ];
            }

            $cTargets[] = [
                'target_id' => $target->subject, //$target->id,
                'grades'    => $grades,
                'start_date' => $target->start_date->format('d M Y'),
                'end_date' => $target->end_date->format('d M Y')
            ];
        }
        $data['current_target_graph'] = $cTargets;
        /***** END *****/


        /***** Past Target Graph (All Target performance) *****/
        $targetSummary = [
            'total' => 0,
            'achieved' => 0,
            'not_achieved' => 0,
            'achieved_targets' => [],
            'not_achieved_targets' => [],
        ];

        /* Define quarter date ranges */
        $dates = [
            1 => [date('Y-01-01'), date('Y-03-31')],
            2 => [date('Y-04-01'), date('Y-06-30')],
            3 => [date('Y-07-01'), date('Y-09-30')],
            4 => [date('Y-10-01'), date('Y-12-31')],
            // 2 => ['01-04-Y', '30-06-Y'],
            // 3 => ['01-07-Y', '30-09-Y'],
            // 4 => ['01-10-Y', '31-12-Y'],
        ];

        // foreach ($data['current_target'] as $target) {
        foreach ($data['past_targets'] as $target) {
            $allGradesAchieved = true;
            foreach ($target->target_quarterly as $quarter) {

                // dump( $quarter, $dates[$quarter->quarterly]);
                foreach ($quarter->target_grade as $target_grade) {
                    $gradeId = $target_grade->grade_id;
                    $totalAmount = OrderManagementProduct::whereHas('order', function ($q) use ($sales_user, $target, $dates, $quarter) {
                        $q->where('salesman_id', $sales_user)
                            ->whereBetween('order_date', $dates[$quarter->quarterly]);  //[$target->start_date, $target->end_date]);
                    })
                        ->whereHas('product', function ($q) use ($gradeId) {
                            $q->where('grade_id', $gradeId);
                        })
                        ->sum('total');
                    // dump($target_grade );
                    // dump($totalAmount, $target_grade->grade_target_value);
                    if ($totalAmount < $target_grade->grade_target_value) {
                        $allGradesAchieved = false;
                        break;
                    }
                }
            }

            $targetSummary['total']++;
            $targetName = $target->subject;

            if ($allGradesAchieved) {
                $targetSummary['achieved']++;
                $targetSummary['achieved_targets'][] = $targetName;
            } else {
                $targetSummary['not_achieved']++;
                $targetSummary['not_achieved_targets'][] = $targetName;
            }
        }

        // ✅ Now calculate percentages
        if ($targetSummary['total'] > 0) {
            $targetSummary['achieved_percentage'] = round(($targetSummary['achieved'] / $targetSummary['total']) * 100, 2);
            $targetSummary['not_achieved_percentage'] = 100 - $targetSummary['achieved_percentage'];
        } else {
            $targetSummary['achieved_percentage'] = 0;
            $targetSummary['not_achieved_percentage'] = 0;
        }

        $data['achived_target'] = $targetSummary;
        // dd( $data['achived_target']);
        /***** END *****/

        return view('admin.sales_person.sales_report', $data);
    }
}
