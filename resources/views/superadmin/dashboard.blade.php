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
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="avatar avatar-md rounded bg-dark mb-3">
                        <i class="ti ti-medal fs-16"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1">{{ $total_dealer }}</h2>
                        <p class="fs-13">Total Dealers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="avatar avatar-md rounded bg-dark mb-3">
                        <i class="ti ti-user-up fs-16"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1">{{ $total_distributor }}</h2>
                        <p class="fs-13">Total Distributors</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="avatar avatar-md rounded bg-dark mb-3">
                        <i class="ti ti-user-star fs-16"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1">{{ $total_sales_person }}</h2>
                        <p class="fs-13">Total Sales Persons</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="avatar avatar-md rounded bg-dark mb-3">
                        <i class="ti ti-businessplan fs-16"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1">{{ $total_product }}</h2>
                        <p class="fs-13">Total Products</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 d-flex"> <!--col-xxl-3 -->
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">Total Orders</h5>
            </div>
            <div class="card-body pb-0">
                <div id="company-chart">
                </div>
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
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">Revenue</h5>
            </div>
            <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="mb-1">
                        <h2 class="mb-1">{{ IndianNumberFormat($order_grand_total) }}</h2>
                    </div>
                    <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                            class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Revenue</p>
                </div>
                <div id="revenue-income"></div>
            </div>
        </div>
    </div>

</div>
<div class="row">
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
                                <p class="fs-13 d-inline-flex align-items-center">
                                    <a href="{{ route('order_management.edit', $order->id) }}">
                                        <spa class="text-info">{{ $order->unique_order_id }}</spa>
                                    </a>
                                    <i class="ti ti-circle-filled fs-4 text-primary mx-1">
                                    </i>{{ $order->order_date->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <h6 class="mb-1">{{ IndianNumberFormat($order->grand_total) }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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
                                        {{ $dealer->firm_shop_name }}
                                    </a>
                                </h6>
                                <p class="fs-13">{{ $dealer->city->city_name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
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
                                                {{ $distributor->firm_shop_name }}</a>
                                        </h6>
                                        <p class="fs-13">{{ $distributor->city->city_name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
