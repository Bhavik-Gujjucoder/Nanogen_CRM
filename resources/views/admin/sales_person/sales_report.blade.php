@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="card flex-fill">
            <div class="card-body">
                <form method="GET" action="{{ route('sales_person.sales_report', ['id' => $sales_user]) }}"
                    class="row align-items-end g-3 mb-4" id="dateFilterForm">

                    <div class="col-md-3">
                        <div class="mb-0">
                            <label class="col-form-label">Start Date</label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="start_date"
                                    value="{{ old('start_date', request()->start_date) }}" id="startDate"
                                    class="form-control" placeholder="DD/MM/YY" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-0">
                            <label class="col-form-label">End Date</label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="end_date" value="{{ old('end_date', request()->end_date) }}"
                                    id="endDate" class="form-control" placeholder="DD/MM/YY" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('sales_person.sales_report', ['id' => $sales_user]) }}"
                            class="btn btn-light w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @can('Order Management')
            <div class="col-xxl-12 d-flex"> <!-- -->
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Total Number of Order</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div id="company-chart"></div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="mb-1">
                                <h5 class="mb-1">{{ $total_order }}</h5>
                            </div>
                            <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Orders</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Revenue</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="mb-1">
                                <h5 class="mb-1">{{ IndianNumberFormat($order_grand_total) }}</h5>
                                {{-- <p><span class="text-success fw-bold">+40%</span> increased from last
                                year</p> --}}
                            </div>
                            <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Revenue</p>
                        </div>
                        <div id="revenue-income"></div>
                    </div>
                </div>
            </div>
        @endcan

        @can('Targets')
            <div class="col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Total Number of Target</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="mb-1">
                                <h5 class="mb-1">{{ $total_target }}</h5>
                            </div>
                            <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Target</p>
                        </div>
                        <div id="revenue-income"></div>
                    </div>
                </div>
            </div>
        @endcan

          @can('Targets')
            <div class="col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Total Target Amount </h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="mb-1">
                                <h5 class="mb-1">{{ IndianNumberFormat($total_target_amount) }}</h5>
                            </div>
                            <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Target</p>
                        </div>
                        <div id="revenue-income"></div>
                    </div>
                </div>
            </div>

             <div class="col-xxl-12 d-flex"> <!-- -->
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Total Number of Target Quarter</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div id="company-chart"></div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="mb-1">
                                <h5 class="mb-1">{{ $sales_person_total_quarter }}</h5>
                            </div>
                            <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Quarter</p>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <!-- All Target Performance -->
    <div class="col-md-6">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">All Target Performance</h5>
            </div>
            <div class="card-body pb-0 round-chart-box">
            <canvas id="targetChart"></canvas>
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">{{ $order_chart_heading }}</h5> {{--Last 12 Months Order Performance--}}
            </div>
            <div class="card-body pb-0">
                <canvas id="orderChart" height="190px"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">{{ $revenu_chart_heading }} </h5>{{--Last 12 Months Revenu Performance --}}
            </div>
            <div class="card-body pb-0">
                <canvas id="revenueChart" height="190px"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- Recent Orders -->
<div class="row">
    @can('Order Management')
        <div class="col-xxl-6 col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2"><i class="ti ti-grip-vertical me-1"></i>Recent Orders</h5>
                    <!-- <a href="{{ route('order_management.index') }}" class="btn btn-light btn-md mb-2">View All</a> -->
                </div>
                <div class="card-body pb-2">
                    <table class="table dataTable no-footer" id="order_management">
                        <thead class="thead-light">
                            <tr>
                                <th class="no-sort" scope="col">
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all" class="order_checkbox"><span
                                            class="checkmarks"></span></label>
                                    </label>
                                </th>
                                <th hidden>ID</th>
                                <th scope="col"><strong>Firm Name</strong></th>
                                <th scope="col"><strong>Order ID</strong></th>
                                <th scope="col"><strong>Order Date</strong></th>
                                <th scope="col"><strong>Salesman</strong></th>
                                <th scope="col"><strong>Total</strong></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @endcan

    @can('Targets')
        <div class="col-xxl-6 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h4><i class="ti ti-grip-vertical me-1"></i>Recent Target</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-table">
                        <table class="table dataTable" id="target_table">
                            <thead class="thead-light">
                                <tr>
                                    <th hidden>ID</th>
                                    <th><strong>Name</strong></th>
                                    <th scope="col"><strong>Salesman</strong></th>
                                    <th><strong>Target Value</strong></th>
                                    <th><strong>Quarterly</strong></th>
                                    
                                    {{-- <th><strong>Start Date</strong></th>
                                    <th><strong>End Date</strong></th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

         <div class="col-xxl-8 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h4><i class="ti ti-grip-vertical me-1"></i>Target Quarterly</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-table">
                        <table class="table dataTable" id="target_quarterly_table">
                            <thead class="thead-light">
                                <tr>
                                    <th hidden>ID</th>
                                    <th><strong>Quarter Name</strong></th>
                                    <th scope="col"><strong>Quarterly Target Amount</strong></th>
                                    <th><strong>Achieved Amount</strong></th>
                                    <th><strong>Win/Loss</strong></th>
                                    
                                    {{-- <th><strong>Start Date</strong></th>
                                    <th><strong>End Date</strong></th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
@can('Targets')
    <div class="row">
        @foreach ($current_target_graph as $index => $target)
            {{-- {{dd($target)}} --}}
            <div class="col-lg-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Running Target #{{ $target['target_id'] }}</h5>
                        {{-- <strong>Start Date : {{ $target['start_date'] }}</strong>
                        <strong>End Date : {{ $target['end_date'] }}</strong> --}}
                        <div>
                            <strong>Start Date : </strong>{{ $target['start_date'] }}
                            &nbsp;&nbsp;&nbsp;<br>
                            <strong>End Date : </strong>{{ $target['end_date'] }}
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <canvas id="gradeBarChart{{ $index }}" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endcan




{{-- <div class="row">
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">All Target performance</h5>
            </div>
            <div class="card-body pb-0">
                <canvas id="targetChart" height="100px"></canvas>
            </div>
        </div>
    </div>
</div> --}}


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    /***** DataTable Order*****/
    var order_management_show = $('#order_management').DataTable({
        "pageLength": ($('#startDate').val() && $('#endDate').val()) ? 10 : 5,
        "paging": true,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        // dom: 'lrtip',
        "dom": 'rtip',
        "bInfo": false,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "{{ route('order_management.index') }}",
            data: function(d) {
                d.salemn_id = '{{ $sales_user }}'; // Pass selected group IDs as a parameter
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'firm_shop_name',
                name: 'firm_shop_name',
                searchable: true,
            },
            {
                data: 'unique_ord_id',
                name: 'unique_ord_id',
                searchable: true
            },

            {
                data: 'order_date',
                name: 'order_date',
                searchable: true,
                orderable: true
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true,
                orderable: true
            },
            {
                data: 'grand_total',
                name: 'grand_total',
                searchable: true,
                orderable: true
            },
        ],
        drawCallback: function() {
            const hasDateFilter = $('#startDate').val() && $('#endDate').val();
            if (!hasDateFilter) {
                $('#order_management_paginate').hide(); // hide pagination controls
            } else {
                $('#order_management_paginate').show(); // show pagination when filtered
            }
        }
    });

    /* DataTable Target quarterly */
     var target_show = $('#target_quarterly_table').DataTable({
        // "pageLength": 10,
        "pageLength": ($('#startDate').val() && $('#endDate').val()) ? 10 : 5,
        "paging": true,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        // dom: 'lrtip',
        "dom": 'rtip',
        "bInfo": false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('target.quarterly') }}",
            data: function(d) {
                d.salemn_id = '{{ $sales_user }}'; // Pass selected group IDs as a parameter
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'quarter_name',
                name: 'quarter_name',
                searchable: true
            },
            {
                data: 'quarterly_target_value',
                name: 'quarterly_target_value',
                searchable: true
            },
            // {
            //     data: 'target_value',
            //     name: 'target_value',
            //     searchable: true,
            //     orderable: true
            // },
             {
                data: 'achived_quarter',
                name: 'achived_quarter',
                searchable: true,
                orderable: true
            },
            {
                data: 'win_loss',
                name: 'win_loss',
                searchable: true,
                orderable: true
            },
         
        ],
        // drawCallback: function() {
        //     const hasDateFilter = $('#startDate').val() && $('#endDate').val();
        //     if (!hasDateFilter) {
        //         $('#target_table_paginate').hide(); // hide pagination controls
        //     } else {
        //         $('#target_table_paginate').show(); // show pagination when filtered
        //     }
        // }
    });

    /***** DataTable Target*****/
    var target_show = $('#target_table').DataTable({
        // "pageLength": 10,
        "pageLength": ($('#startDate').val() && $('#endDate').val()) ? 10 : 5,
        "paging": true,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        // dom: 'lrtip',
        "dom": 'rtip',
        "bInfo": false,
        order: [
            [0, 'desc']
        ],
        // ajax: "{{ route('target.index') }}",
        ajax: {
            url: "{{ route('target.index') }}",
            data: function(d) {
                d.salemn_id = '{{ $sales_user }}'; // Pass selected group IDs as a parameter
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'subject_name',
                name: 'subject_name',
                searchable: true
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true
            },
            {
                data: 'target_value',
                name: 'target_value',
                searchable: true,
                orderable: true
            },
            {
                data: 'quarterly',
                name: 'quarterly',
                searchable: true,
                orderable: true
            },
            // {
            //     data: 'city_id',
            //     name: 'city_id',
            //     searchable: true,
            //     orderable: true
            // },
            // {
            //     data: 'start_date',
            //     name: 'start_date',
            //     searchable: true
            // },
            // {
            //     data: 'end_date',
            //     name: 'end_date',
            //     searchable: true
            // },
        ],
        drawCallback: function() {
            const hasDateFilter = $('#startDate').val() && $('#endDate').val();
            if (!hasDateFilter) {
                $('#target_table_paginate').hide(); // hide pagination controls
            } else {
                $('#target_table_paginate').show(); // show pagination when filtered
            }
        }
    });





    /***** Running Target Graph*****/
    @foreach ($current_target_graph as $index => $target)

        const ctx{{ $index }} = document.getElementById('gradeBarChart{{ $index }}').getContext('2d');
        const gradeLabels{{ $index }} = @json(collect($target['grades'])->pluck('grade_id'));
        const achievedPercentages{{ $index }} = @json(collect($target['grades'])->pluck('achieved_percentage'));

        new Chart(ctx{{ $index }}, {
            type: 'bar',
            data: {
                labels: gradeLabels{{ $index }},
                datasets: [{
                    label: 'Achieved %',
                    data: achievedPercentages{{ $index }},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Target Name: {{ $target['target_id'] }} - Grade-wise Performance'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100, // Max 100% for clarity
                        title: {
                            display: true,
                            text: 'Achieved Percentage'
                        }
                    }
                }
            }
        });
    @endforeach
    /***Running Target Graph END ***/



    /***** 12 Month Order Chart *****/
    const order_chart = @json($order_chart);
    const order_chart_labels = order_chart.map(d => d.month);
    const order_chart_counts = order_chart.map(d => d.total);

        const order_chart_draw = document.getElementById('orderChart').getContext('2d');
        const orderChart = new Chart(order_chart_draw, {
            type: 'bar',
            data: {
                labels: order_chart_labels,
                datasets: [{
                    label: 'Orders',
                    data: order_chart_counts,
                    backgroundColor: '#00918e',
                    borderRadius: 6,
                    barThickness: 40 //30
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        color: '#fff', // White text inside bars
                        anchor: 'center',
                        align: 'center',
                        font: {
                            weight: 'bold',
                            size: 16 //14
                        },
                        formatter: function(value) {
                            return value;
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Set the interval to 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: false,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    
    /***12 Month Order Chart END ***/



    /***** 12 Month Revenu Chart *****/
    const revenueData = @json($revenue_chart);
    const labels = revenueData.map(d => d.month);
    const totals = revenueData.map(d => d.total);

    function indianNumberFormatScript(x) {
        x = x.toString();
        let afterPoint = '';
        if (x.indexOf('.') > 0)
            afterPoint = x.substring(x.indexOf('.'), x.length);
        x = Math.floor(x).toString();
        let lastThree = x.substring(x.length - 3);
        let otherNumbers = x.substring(0, x.length - 3);
        if (otherNumbers != '')
            lastThree = ',' + lastThree;
        return '₹' + otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    }
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: totals,
                    backgroundColor: '#ff9933',
                    borderRadius: 6,
                    barThickness: 40
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        // min: 100,
                        min: 0,
                        ticks: {
                            stepSize: 5000,
                            precision: 0, // Force tick precision to avoid rounding
                            callback: function(value) {
                                return indianNumberFormatScript(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return 'Revenue: ' + indianNumberFormatScript(value);
                            }
                        }
                    }
                }
            }
        });

    /***12 Month Revenu Chart END ***/



    /*** All Target performance ***/
    function getRandomColorHex() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
    }

    const achived_target_chart = @json($achived_target);
    
    // if (achived_target_chart && achived_target_chart.achieved_percentage != undefined && achived_target_chart
    // .achieved_percentage != 0) {

        if (achived_target_chart) {
            console.log(achived_target_chart)
            
            
        const achived_target_chart_labels = ['Won', 'Lost']; //['Achieved', 'Not Achieved'];
        const achived_target_chart_percentage = [
            parseFloat(achived_target_chart.achieved_percentage),
            parseFloat(achived_target_chart.not_achieved_percentage)
        ];
        const won_target_name = achived_target_chart.achieved_targets; // achived target 
        const loss_target_name = achived_target_chart.not_achieved_targets; // not achived target
        const colors = ['#28a745', '#dc3545']; // Green for achieved, red for not achieved
        const ctx = document.getElementById("targetChart").getContext("2d");

        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: achived_target_chart_labels,
                datasets: [{
                    data: achived_target_chart_percentage,
                    backgroundColor: colors,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Achieved Target Percentages'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                const label = context.label;
                                const value = context.formattedValue;
                                let targetNames = [];

                                if (index === 0) {
                                    // Achieved
                                    targetNames = won_target_name.length ? won_target_name : ['None'];
                                } else {
                                    // Not Achieved
                                    targetNames = loss_target_name.length ? loss_target_name : ['None'];
                                }
                                return [
                                    `${label}: ${value}%`,
                                    'Target Name:',
                                    ...targetNames.map(name => '• ' + name)
                                ];
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 13
                        },
                        formatter: (value) => value + '%'
                    }
                }
            },
            plugins: [ChartDataLabels] // Uncomment this if using ChartDataLabels plugin
        });
    } else {
        console.warn("No summary target data is available for 'All Target Performance'.");

        // Get the canvas container and inject message
        const canvasContainer = document.getElementById("targetChart").parentNode;
        canvasContainer.innerHTML = `
        <div style="height: 380px; width: 380px; display: flex; justify-content: center; align-items: center; color: #999; font-weight: bold;">
            No data available.
        </div>
    `;
    }
    /***All Target performance END ***/
</script>
<script>
    /*** datepicker ***/
    $(document).ready(function() {
        const startPicker = flatpickr("#startDate", {
            dateFormat: "d-m-Y",
            disableMobile: true,
            maxDate: "today",
            defaultDate: "{{ old('start_date', request()->start_date) }}",
            onChange: function(selectedDates, dateStr, instance) {
                // Set selected start date as minDate for end date
                endPicker.set('minDate', dateStr);
                removeTodayHighlight(selectedDates, dateStr, instance);
            },
            onReady: removeTodayHighlight,
            onMonthChange: removeTodayHighlight,
            onYearChange: removeTodayHighlight,
            onOpen: removeTodayHighlight
        });

        const endPicker = flatpickr("#endDate", {
            dateFormat: "d-m-Y",
            disableMobile: true,
            maxDate: "today",
            defaultDate: "{{ old('end_date', request()->end_date) }}",
            onReady: removeTodayHighlight,
            onMonthChange: removeTodayHighlight,
            onYearChange: removeTodayHighlight,
            onOpen: removeTodayHighlight
        });

        function removeTodayHighlight(selectedDates, dateStr, instance) {
            const todayElem = instance.calendarContainer.querySelector(".flatpickr-day.today");
            if (todayElem && !todayElem.classList.contains("selected")) {
                todayElem.classList.remove("today");
            }
        }
    });

    /*** END ***/
</script>
@endsection
