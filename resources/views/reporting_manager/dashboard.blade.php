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
<!-- /Welcome Wrap -->
<div class="row">
    <!-- Total Companies -->
    @can('Dealers')
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-medal fs-16"></i>
                        </span>
                        {{-- <span class="badge bg-success fw-normal mb-3">
                            +19.01%
                        </span> --}}
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">{{ $total_dealer }}</h2>
                            <p class="fs-13">Total Dealers</p>
                        </div>
                        {{-- <div class="company-bar1">5,10,7,5,10,7,5</div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!-- /Total Companies -->
    <!-- Active Companies -->
    @can('Distributors')
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-user-up fs-16"></i>
                        </span>
                        {{-- <span class="badge bg-danger fw-normal mb-3">
                            -12%
                        </span> --}}
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">{{ $total_distributor }}</h2>
                            <p class="fs-13">Total Distributors</p>
                        </div>
                        {{-- <div class="company-bar2">5,3,7,6,3,10,5</div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!-- /Active Companies -->
    <!-- Total Subscribers -->
    @can('Sales Persons')
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-user-star fs-16"></i>
                        </span>
                        {{-- <span class="badge bg-success fw-normal mb-3">
                            +6%
                        </span> --}}
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">{{ $total_sales_person }}</h2>
                            <p class="fs-13">Total Sales Persons</p>
                        </div>
                        {{-- <div class="company-bar3">8,10,10,8,8,10,8</div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!-- /Total Subscribers -->
    <!-- Total Earnings -->
    @can('Products and Catalogue')
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-businessplan fs-16"></i>
                        </span>
                        {{-- <span class="badge bg-danger fw-normal mb-3">
                            -16%
                        </span> --}}
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">{{ $total_product }}</h2>
                            <p class="fs-13">Total Products</p>
                        </div>
                        {{-- <div class="company-bar4">5,10,7,5,10,7,5</div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!-- /Total Earnings -->
</div>
@can('Order Management')
    <div class="row">
        <!--  Total Orders -->
        <div class="col-lg-6 d-flex"> <!--col-xxl-3 -->
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Total Orders</h5>
                    {{-- <div class="dropdown mb-2">
                        <a href="javascript:void(0);"
                            class="btn btn-white border btn-sm d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-calendar me-1"></i>This Week
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body pb-0">
                    <div id="company-chart">

                    </div>
                    {{-- <p class="f-13 d-inline-flex align-items-center"><span class="badge badge-success me-1">+6%</span> 5
                        Companies from last month
                    </p> --}}
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mb-1">
                            <h2 class="mb-1">{{ $total_order }}</h2>
                        </div>
                        <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Orders</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Companies -->
        <!-- Revenue -->
        <div class="col-lg-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Revenue</h5>
                    {{-- <div class="dropdown mb-2">
                        <a href="javascript:void(0);"
                            class="btn btn-white border btn-sm d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-calendar me-1"></i>2025
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">2025</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mb-1">
                            <h2 class="mb-1">₹{{ $order_grand_total }}</h2>
                            {{-- <p><span class="text-success fw-bold">+40%</span> increased from last year</p> --}}
                        </div>
                        <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Revenue</p>
                    </div>
                    <div id="revenue-income"></div>
                </div>
            </div>
        </div>
        <!-- /Revenue -->

    </div>
@endcan
<div class="row">
    <!-- Recent Orders -->
    @can('Order Management')
        <div class="col-xxl-4 col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Recent Orders</h5>
                    <a href="{{ route('order_management.index') }}" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body pb-2">
                    @foreach ($latest_orders as $order)
                        <div class="d-flex justify-content-between flex-wrap mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                    <img src="images/company-icon-01.svg" class="img-fluid w-auto h-auto" alt="img">
                                </a>
                                <div class="ms-2 flex-fill">
                                    <h6 class="fs-medium text-truncate mb-1">
                                        <a href="{{ route('order_management.edit', $order->id) }}">
                                            {{ $order->distributors_dealers->firm_shop_name }}
                                        </a>
                                    </h6>
                                    <p class="fs-13 d-inline-flex align-items-center">
                                        <spa class="text-info">{{ $order->unique_order_id }}</spa>
                                        <i class="ti ti-circle-filled fs-4 text-primary mx-1">
                                        </i>{{ $order->order_date->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-sm-end mb-2">
                                <h6 class="mb-1">₹{{ $order->grand_total }}</h6>
                                <!-- <p class="fs-13">Basic (Monthly)</p> -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endcan
    @can('Dealers')
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2"> Recent Dealers </h5>
                    <a href="{{ route('distributors_dealers.index', 1) }}" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body pb-2">
                    @foreach ($latest_dealers as $dealer)
                        <div class="d-flex justify-content-between flex-wrap mb-3">
                            <div class="d-flex align-items-center mb-2">

                                <a href="{{ $dealer && $dealer->profile_image
                                    ? asset('storage/distributor_dealer_profile_image/' . $dealer->profile_image)
                                    : asset('images/default-user.png') }}"
                                    class="avatar avatar-sm border flex-shrink-0" target="_blank">
                                    <img id="profilePreview"
                                        src="{{ $dealer && $dealer->profile_image
                                            ? asset('storage/distributor_dealer_profile_image/' . $dealer->profile_image)
                                            : asset('images/default-user.png') }}"
                                        alt="Profile Image" class="img-thumbnail mb-2">
                                </a>

                                <div class="ms-2 flex-fill">
                                    <h6 class="fs-medium text-truncate mb-1">
                                        <a href="{{ route('distributors_dealers.edit', $dealer->id) }}">
                                            {{ $dealer->applicant_name }}
                                        </a>
                                    </h6>
                                    <p class="fs-13">{{ $dealer->city->city_name ?? '-' }}</p>
                                </div>
                            </div>
                            {{-- <div class="text-sm-end mb-2">
                            <p class="fs-13 mb-1">123 Dealer Form</p>
                            <h6 class="fs-13 fw-normal">234 O form</h6>
                        </div> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endcan
    <!-- /Recent Dealers-->
    <!-- Recent Distributors -->
    @can('Distributors')
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Recent Distributors</h5>
                    <a href="{{ route('distributors_dealers.index') }}" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body pb-2">
                    <div>
                        <div>
                            @foreach ($latest_distributor as $distributor)
                                <div class="d-flex justify-content-between flex-wrap mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="{{ $distributor && $distributor->profile_image
                                            ? asset('storage/distributor_dealer_profile_image/' . $distributor->profile_image)
                                            : asset('images/default-user.png') }}"
                                            class="avatar avatar-sm border flex-shrink-0" target="_blank">

                                            <img id="profilePreview"
                                                src="{{ $distributor && $distributor->profile_image
                                                    ? asset('storage/distributor_dealer_profile_image/' . $distributor->profile_image)
                                                    : asset('images/default-user.png') }}"
                                                alt="Profile Image" class="img-thumbnail mb-2">
                                        </a>
                                        <div class="ms-2 flex-fill">
                                            <h6 class="fs-medium text-truncate mb-1"><a
                                                    href="{{ route('distributors_dealers.edit', $distributor->id) }}">
                                                    {{ $distributor->applicant_name }}</a>
                                            </h6>

                                            <p class="fs-13">{{ $distributor->city->city_name ?? '-' }}</p>
                                        </div>
                                    </div>
                                    {{-- <div class="text-sm-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="link-info text-decoration-underline d-block mb-1">Send
                                        Reminder</a>
                                    <p class="fs-13">Basic (Monthly)</p>
                                </div> --}}
                                </div>
                            @endforeach



                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!-- /Recent Distributors -->
</div>
</div>
@endsection
