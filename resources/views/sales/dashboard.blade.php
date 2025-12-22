@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<!-- Welcome Wrap -->
<div class="welcome-wrap mb-4">
    <div class=" d-flex align-items-center justify-content-between flex-wrap">
        <div class="mb-3">
            <h2 class="mb-1 text-white">Welcome Back, {{ auth()->user()->name }}</h2>
            <p class="text-light"></p>
        </div>
    </div>
</div>
<div class="row detials-gc-user">


</div>
<div class="row">
    @can('Order Management')
        <!--  Total Orders -->
        <div class="col-xxl-4 col-lg-6 d-flex"> <!-- -->
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Total Orders</h5>
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
        @if ($self_recent_orders->count() > 0)
            <div class="col-xxl-6 col-xl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Self Recent Orders</h5>
                        <a href="{{ route('order_management.index') }}" class="btn btn-light btn-md mb-2">View All</a>
                    </div>
                    <div class="card-body pb-2">
                        @foreach ($self_recent_orders as $order)
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
        @endif
        @if ($other_recent_orders->count() > 0)
            <div class="col-xxl-6 col-xl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-2">Team Recent Orders</h5>
                        <a href="{{ route('order_management.index') }}" class="btn btn-light btn-md mb-2">View All</a>
                    </div>
                    <div class="card-body pb-2">
                        @foreach ($other_recent_orders as $order)
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
        @endif
        <!-- /Recent Orders -->
    @endcan

    @can('Targets')
        @if ($self_latest_target->count() > 0)
            <div class="col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h4><i class="ti ti-grip-vertical me-1"></i>Self Recent Target</h4>
                            <a href="{{ route('target.index') }}" class="btn btn-light btn-md mb-2">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-table">
                            <table class="table dataTable" id="deals-project">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Target Name</th>
                                        <th>Target Value</th>
                                        <th>Quarter</th>
                                        {{-- <th>Start Date</th>
                                    <th>End Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($self_latest_target as $t)
                                        <tr>
                                            <td>{{ $t->subject }}</td>
                                            <td>{{ IndianNumberFormat($t->target_value) }}</td>
                                            <td>
                                                @foreach ($t->target_quarterly as $quarter)
                                                    <span class="badge bg-gray me-1 mb-1">
                                                        Quarterly {{ $quarter->quarterly }} ⮚
                                                        {{ $quarter->quarterly_percentage }}%
                                                    </span><br>
                                                @endforeach
                                                {{ $t->quarter }}
                                            </td>
                                            {{-- <td>{{ $t->start_date->format('d M Y') }}</td>
                                        <td>{{ $t->end_date->format('d M Y') }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($other_latest_target->count() > 0)
            <div class="col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h4><i class="ti ti-grip-vertical me-1"></i>Team Recent Target</h4>
                            <a href="{{ route('target.index') }}" class="btn btn-light btn-md mb-2">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-table">
                            <table class="table dataTable" id="deals-project">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Target Name</th>
                                        <th>Target Value</th>
                                        <th>Quarter</th>
                                        {{-- <th>Start Date</th>
                                    <th>End Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($other_latest_target as $t)
                                        <tr>
                                            <td>{{ $t->subject }}</td>
                                            <td>{{ IndianNumberFormat($t->target_value) }}</td>
                                            <td>
                                                @foreach ($t->target_quarterly as $quarter)
                                                    <span class="badge bg-gray me-1 mb-1">
                                                        Quarterly {{ $quarter->quarterly }} ⮚
                                                        {{ $quarter->quarterly_percentage }}%
                                                    </span><br>
                                                @endforeach
                                                {{ $t->quarter }}
                                            </td>
                                            {{-- <td>{{ $t->start_date->format('d M Y') }}</td>
                                        <td>{{ $t->end_date->format('d M Y') }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

{{-- <div class="col-lg-11 d-flex">
    <div class="card flex-fill">
        <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
            <h5 class="mb-2">Running Target</h5> 
        </div>
        <div class="card-body pb-0">
            <canvas id="gradeBarChart" height="300"></canvas>
        </div>
    </div>
</div> --}}
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
</script>
{{-- <script> 



const ctx = document.getElementById('gradeBarChart').getContext('2d');

        const gradeLabels = @json($current_target_graph->pluck('grade_id'));
        const orderCounts = @json($current_target_graph->pluck('achieved_percentage'));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: gradeLabels,
                datasets: [{
                    label: 'Order Count',
                    data: orderCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Makes it horizontal
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Grade-wise Order Count'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script> --}}
@endsection
