@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection


<div class="row">

    <!-- Total Earnings -->
    {{-- <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-businessplan fs-16"></i>
                        </span>
                        <span class="badge bg-danger fw-normal mb-3">
                            -16%
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">$89,878,58</h2>
                            <p class="fs-13">Total Products</p>
                        </div>
                        <div class="company-bar4">5,10,7,5,10,7,5</div>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- /Total Earnings -->
</div>
<div class="row">
    @can('Order Management')
        <!--  Total Orders -->
        <div class="col-xxl-4 col-lg-6 d-flex"> <!-- -->
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Total Number of Order</h5>
                </div>
                <div class="card-body">
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
        <!-- /Companies -->

        <!-- Revenue -->
        <div class="col-xxl-4 col-lg-6 d-flex">
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
    <!-- /Revenue -->
    @can('Targets')
        <!-- Revenue -->
        <div class="col-xxl-4 col-lg-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Total Number of Target</h5>
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mb-1">
                            <h5 class="mb-1">{{ $total_target }}</h5>
                            {{-- <p><span class="text-success fw-bold">+40%</span> increased from last
                                year</p> --}}
                        </div>
                        <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Target</p>
                    </div>
                    <div id="revenue-income"></div>
                </div>
            </div>
        </div>
        <!-- /Revenue -->
    @endcan
</div>
<div class="row">
    @can('Order Management')
        <!-- Recent Orders -->
        <div class="col-xxl-4 col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Recent Orders</h5>
                    {{-- <a href="{{ route('order_management.index') }}" class="btn btn-light btn-md mb-2">View All</a> --}}
                </div>
                <div class="card-body pb-2">
                    @foreach ($latest_orders as $order)
                        <div class="d-flex justify-content-between flex-wrap mb-3">
                            <div class="d-flex align-items-center mb-2">
                                {{-- <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                    <img src="images/company-icon-01.svg" class="img-fluid w-auto h-auto" alt="img">
                                </a> --}}
                                <a href="{{ $order->distributors_dealers->profile_image
                                    ? asset('storage/distributor_dealer_profile_image/' . $order->distributors_dealers->profile_image)
                                    : asset('images/default-user.png') }}"
                                    class="avatar avatar-sm border flex-shrink-0" target="_blank">
                                    <img id="profilePreview"
                                        src="{{ $order->distributors_dealers->profile_image
                                            ? asset('storage/distributor_dealer_profile_image/' . $order->distributors_dealers->profile_image)
                                            : asset('images/default-user.png') }}"
                                        alt="Profile Image" class="img-thumbnail mb-2">
                                </a>
                                <div class="ms-2 flex-fill">
                                    <h6 class="fs-medium text-truncate mb-1">
                                        <a href="{{ route('order_management.edit', $order->id) }}">
                                            {{ $order->distributors_dealers->firm_shop_name }}
                                        </a>
                                    </h6>
                                    <p class="fs-13 d-inline-flex align-items-center"> <a
                                            href="{{ route('order_management.edit', $order->id) }}">
                                            <spa class="text-info">{{ $order->unique_order_id }}</spa>
                                        </a>
                                        <i class="ti ti-circle-filled fs-4 text-primary mx-1">
                                        </i>{{ $order->order_date->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-sm-end mb-2">
                                <h6 class="mb-1">{{ IndianNumberFormat($order->grand_total) }}</h6>
                                <!-- <p class="fs-13">Basic (Monthly)</p> -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /Recent Orders -->
    @endcan

    @can('Targets')
        <div class="col-md-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h4><i class="ti ti-grip-vertical me-1"></i>Recent Target</h4>
                        {{-- <a href="{{ route('target.index') }}" class="btn btn-light btn-md mb-2">View All</a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-table">
                        <table class="table dataTable" id="deals-project">
                            <thead class="thead-light">
                                <tr>
                                    <th>Target Name</th>
                                    <th>Target Value</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_target as $t)
                                    <tr>
                                        <td>{{ $t->subject }}</td>
                                        <td>{{ IndianNumberFormat($t->target_value) }}</td>
                                        <td>{{ $t->start_date->format('d M Y') }}</td>
                                        <td>{{ $t->end_date->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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

<div class="row">
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">Last 12 months Order performance</h5>
                {{-- <strong>Start Date : {{ $target['start_date'] }}</strong>
                <strong>End Date : {{ $target['end_date'] }}</strong> --}}
            </div>
            <div class="card-body pb-0">
                <canvas id="orderChart" height="190px"></canvas>
            </div>
        </div>
    </div>
    {{-- </div>

<div class="row"> --}}
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">Last 12 months Revenu performance</h5>
                {{-- <strong>Start Date : {{ $target['start_date'] }}</strong>
                <strong>End Date : {{ $target['end_date'] }}</strong> --}}
            </div>
            <div class="card-body pb-0">
                <canvas id="revenueChart" height="190px" ></canvas>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    /***** Running Target *****/
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
    /*** END ***/

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
    /*** END ***/

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
    /*** END ***/
</script>
@endsection
