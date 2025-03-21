@extends('layouts.main')
@section('content')
    @section('title')
        {{ $page_title }}
    @endsection

    <!-- Welcome Wrap -->
    <div class="welcome-wrap mb-4">
        <div class=" d-flex align-items-center justify-content-between flex-wrap">
            <div class="mb-3">
                <h2 class="mb-1 text-white">Welcome Back, {{auth()->user()->name}}</h2>
                <p class="text-light"></p>
            </div>
        </div>
    </div>
    <!-- /Welcome Wrap -->
    <div class="row">
        <!-- Total Companies -->
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-medal fs-16"></i>
                        </span>
                        <span class="badge bg-success fw-normal mb-3">
                            +19.01%
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">5468</h2>
                            <p class="fs-13">Total Dealers</p>
                        </div>
                        <div class="company-bar1">5,10,7,5,10,7,5</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Total Companies -->
        <!-- Active Companies -->
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-user-up fs-16"></i>
                        </span>
                        <span class="badge bg-danger fw-normal mb-3">
                            -12%
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">4598</h2>
                            <p class="fs-13">Total Distributors</p>
                        </div>
                        <div class="company-bar2">5,3,7,6,3,10,5</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Active Companies -->
        <!-- Total Subscribers -->
        <div class="col-xl-3 col-sm-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="avatar avatar-md rounded bg-dark mb-3">
                            <i class="ti ti-user-star fs-16"></i>
                        </span>
                        <span class="badge bg-success fw-normal mb-3">
                            +6%
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1">3698</h2>
                            <p class="fs-13">Total Sales Persons</p>
                        </div>
                        <div class="company-bar3">8,10,10,8,8,10,8</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Total Subscribers -->
        <!-- Total Earnings -->
        <div class="col-xl-3 col-sm-6 d-flex">
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
        </div>
        <!-- /Total Earnings -->
    </div>
    <div class="row">
        <!--  Total Orders -->
        <div class="col-xxl-3 col-lg-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Total Orders</h5>
                    <div class="dropdown mb-2">
                        <a href="javascript:void(0);"
                            class="btn btn-white border btn-sm d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-calendar me-1"></i>This Week
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">This
                                    Month</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">This
                                    Week</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="company-chart"></div>
                    <p class="f-13 d-inline-flex align-items-center"><span class="badge badge-success me-1">+6%</span> 5
                        Companies from last month
                    </p>
                </div>
            </div>
        </div>
        <!-- /Companies -->
        <!-- Revenue -->
        <div class="col-lg-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Revenue</h5>
                    <div class="dropdown mb-2">
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
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mb-1">
                            <h5 class="mb-1">$45787</h5>
                            <p><span class="text-success fw-bold">+40%</span> increased from last
                                year</p>
                        </div>
                        <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Revenue</p>
                    </div>
                    <div id="revenue-income"></div>
                </div>
            </div>
        </div>
        <!-- /Revenue -->
        <!-- Top Plans -->
        <div class="col-xxl-3 col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Top Plans</h5>
                    <div class="dropdown mb-2">
                        <a href="javascript:void(0);"
                            class="btn btn-white border btn-sm d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-calendar me-1"></i>This Month
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">This
                                    Month</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">This
                                    Week</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="plan-overview"></div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <p class="f-13 mb-0"><i class="ti ti-circle-filled text-primary me-1"></i>Basic
                        </p>
                        <p class="f-13 fw-medium text-gray-9">60%</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <p class="f-13 mb-0"><i class="ti ti-circle-filled text-warning me-1"></i>Premium
                        </p>
                        <p class="f-13 fw-medium text-gray-9">20%</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <p class="f-13 mb-0"><i class="ti ti-circle-filled text-info me-1"></i>Enterprise
                        </p>
                        <p class="f-13 fw-medium text-gray-9">20%</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Top Plans -->
    </div>
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xxl-4 col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Recent Orders</h5>
                    <a href="order-management.html" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body pb-2">
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/company-icon-01.svg" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Chamunda Agro.
                                        center</a></h6>
                                <p class="fs-13 d-inline-flex align-items-center"><span
                                        class="text-info">#12457</span><i
                                        class="ti ti-circle-filled fs-4 text-primary mx-1"></i>14
                                    Jan 2025</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <h6 class="mb-1">10</h6>
                            <!-- <p class="fs-13">Basic (Monthly)</p> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/company-icon-02.svg" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Patel Agro.
                                        center</a></h6>
                                <p class="fs-13 d-inline-flex align-items-center"><span
                                        class="text-info">#65974</span><i
                                        class="ti ti-circle-filled fs-4 text-primary mx-1"></i>14
                                    Jan 2025</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <h6 class="mb-1">20</h6>
                            <!-- <p class="fs-13">Enterprise (Yearly)</p> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/company-icon-03.svg" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Khodiyar Agro.
                                        center</a></h6>
                                <p class="fs-13 d-inline-flex align-items-center"><span
                                        class="text-info">#22457</span><i
                                        class="ti ti-circle-filled fs-4 text-primary mx-1"></i>14
                                    Jan 2025</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <h6 class="mb-1">30</h6>
                            <!-- <p class="fs-13">Advanced (Monthly)</p> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/company-icon-04.svg" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Chamunda Agro.
                                        center</a></h6>
                                <p class="fs-13 d-inline-flex align-items-center"><span
                                        class="text-info">#43412</span><i
                                        class="ti ti-circle-filled fs-4 text-primary mx-1"></i>14
                                    Jan 2025</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <h6 class="mb-1">10</h6>
                            <!-- <p class="fs-13">Enterprise (Monthly)</p> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-1">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/company-icon-05.svg" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Patel Agro.
                                        center</a></h6>
                                <p class="fs-13 d-inline-flex align-items-center"><span
                                        class="text-info">#43567</span><i
                                        class="ti ti-circle-filled fs-4 text-primary mx-1"></i>14
                                    Jan 2025</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <h6 class="mb-1">20</h6>
                            <!-- <p class="fs-13">Premium (Yearly)</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Recent Orders -->
        <!-- Recent Dealers -->
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2"> Recent Dealers </h5>
                    <a href="dealers.html" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body pb-2">
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/avatar-14.png" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                        Robertson</a></h6>
                                <p class="fs-13">info@gmail.com</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <p class="fs-13 mb-1">123 Dealer Form</p>
                            <h6 class="fs-13 fw-normal">234 O form</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/avatar-14.png" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                        Robertson</a></h6>
                                <p class="fs-13">info@gmail.com</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <p class="fs-13 mb-1">789 Dealer Form</p>
                            <h6 class="fs-13 fw-normal">234 O form</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/avatar-14.png" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                        Robertson</a></h6>
                                <p class="fs-13">Advanced (Monthly)</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <p class="fs-13 mb-1">234 Dealer Form</p>
                            <h6 class="fs-13 fw-normal">456 O form</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/avatar-14.png" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                        Robertson</a></h6>
                                <p class="fs-13">Advanced (Monthly)</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <p class="fs-13 mb-1">234 Dealer Form</p>
                            <h6 class="fs-13 fw-normal">456 O form</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-1">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                <img src="images/avatar-14.png" class="img-fluid w-auto h-auto" alt="img">
                            </a>
                            <div class="ms-2 flex-fill">
                                <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                        Robertson</a></h6>
                                <p class="fs-13">Premium (Yearly)</p>
                            </div>
                        </div>
                        <div class="text-sm-end mb-2">
                            <p class="fs-13 mb-1">123 Dealer Form</p>
                            <h6 class="fs-13 fw-normal">456 O form</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Recent Dealers-->
        <!-- Recent Distributors -->
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Recent Distributors</h5>
                    <a href="distributors.html" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body pb-2">
                    <div>
                        <div>
                            <div class="d-flex justify-content-between flex-wrap mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                        <img src="images/avatar-14.png" class="img-fluid w-auto h-auto"
                                            alt="img">
                                    </a>
                                    <div class="ms-2 flex-fill">
                                        <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);"> Darlee
                                                Robertson </a>
                                        </h6>
                                        <p class="fs-13">info@gmail.com</p>
                                    </div>
                                </div>
                                <div class="text-sm-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="link-info text-decoration-underline d-block mb-1">Send
                                        Reminder</a>
                                    <p class="fs-13">Basic (Monthly)</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                        <img src="images/avatar-14.png" class="img-fluid w-auto h-auto"
                                            alt="img">
                                    </a>
                                    <div class="ms-2 flex-fill">
                                        <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Summit
                                                Patel</a></h6>
                                        <p class="fs-13">info@gmail.com</p>
                                    </div>
                                </div>
                                <div class="text-sm-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="link-info text-decoration-underline d-block mb-1">Send
                                        Reminder</a>
                                    <p class="fs-13">Enterprise (Yearly)</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                        <img src="images/avatar-14.png" class="img-fluid w-auto h-auto"
                                            alt="img">
                                    </a>
                                    <div class="ms-2 flex-fill">
                                        <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Summit
                                                Patel</a></h6>
                                        <p class="fs-13">info@gmail.com</p>
                                    </div>
                                </div>
                                <div class="text-sm-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="link-info text-decoration-underline d-block mb-1">Send
                                        Reminder</a>
                                    <p class="fs-13">Advanced (Monthly)</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap mb-1">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                        <img src="images/avatar-14.png" class="img-fluid w-auto h-auto"
                                            alt="img">
                                    </a>
                                    <div class="ms-2 flex-fill">
                                        <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                                Robertson</a></h6>
                                        <p class="fs-13">info@gmail.com</p>
                                    </div>
                                </div>
                                <div class="text-sm-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="link-info text-decoration-underline d-block mb-1">Send
                                        Reminder</a>
                                    <p class="fs-13">Premium (Yearly)</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap mb-1">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="javscript:void(0);" class="avatar avatar-sm border flex-shrink-0">
                                        <img src="images/avatar-14.png" class="img-fluid w-auto h-auto"
                                            alt="img">
                                    </a>
                                    <div class="ms-2 flex-fill">
                                        <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">Darlee
                                                Robertson</a></h6>
                                        <p class="fs-13">info@gmail.com</p>
                                    </div>
                                </div>
                                <div class="text-sm-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="link-info text-decoration-underline d-block mb-1">Send
                                        Reminder</a>
                                    <p class="fs-13">Premium (Yearly)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Recent Distributors -->
    </div>
@endsection
