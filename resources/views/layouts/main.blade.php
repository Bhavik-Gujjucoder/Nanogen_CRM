<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="NANOGEN - AGROCHEM PVT. LTD. " />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <!-- Title -->
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tabler-icons/tabler-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href="{{ asset('css/toastify.css') }}" rel="stylesheet">

    <!-- include summernote css/js -->
    <link rel="stylesheet" href="{{ asset('css/summernote-bs4.min.css') }}">
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            <div class="header-left active">
                <a href="javascript:void(0)" class="logo logo-normal">
                    @if (getSetting('company_logo') && !empty(getSetting('company_logo')) )
                        <img src="{{ asset('storage/company_logo/'.getSetting('company_logo')) }}" alt="Logo">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    @endif
                </a>
                <a id="toggle_btn" href="javascript:void(0);"><i class="ti ti-arrow-bar-to-left"></i></a>
            </div>
            <!-- /Logo -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <div class="header-user">
                <ul class="nav user-menu">
                    <!-- Search -->
                    <li class="nav-item nav-search-inputs me-auto">
                        <div class="top-nav-search">
                            <a href="javascript:void(0);" class="responsive-search">
                                <i class="fa fa-search"></i>
                            </a>
                            <!-- <form action="#" class="dropdown">
                    <div class="searchinputs" id="dropdownMenuClickable">
                        <input type="text" placeholder="Search">
                        <div class="search-addon">
                            <button type="submit"><i class="ti ti-command"></i></button>
                        </div>
                    </div>
                    </form> -->
                        </div>
                    </li>
                    <!-- /Search -->
                    <!-- Nav List -->
                    <li class="nav-item nav-list">
                        <ul class="nav">
                            <li class="nav-item dropdown">
                                <a href="javascript:void(0);" class="btn btn-header-list" data-bs-toggle="dropdown">
                                    <i class="ti ti-layout-grid-add"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end menus-info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="menu-list">
                                                <li>
                                                    <a href="state-management.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-green">
                                                                <i class="ti ti-map-pin-pin"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>State Management</p>
                                                                <span>Add New State Management</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="city-management.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-violet">
                                                                <i class="ti ti-map-pin-pin"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>City Management</p>
                                                                <span>Add City Management</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!--  <li>
                                    <a href="contacts.html">
                                        <div class="menu-details">
                                        <span class="menu-list-icon bg-pink">
                                        <i class="ti ti-steam"></i>
                                        </span>
                                        <div class="menu-details-content">
                                            <p>Contacts</p>
                                            <span>Add New contacts</span>
                                        </div>
                                        </div>
                                    </a>
                                </li> -->
                                                <li>
                                                    <a href="sales-reports.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-info">
                                                                <i class="ti ti-file-invoice"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Sales Reports</p>
                                                                <span>Add New Sales Report</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="product-catelog.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-danger">
                                                                <i class="ti ti-atom-2"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Products and Catalogue</p>
                                                                <span>Add New Products and Catalogue</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="pricing-product-variation.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-info">
                                                                <i class="ti ti-medal"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Pricing and Product Variation</p>
                                                                <span>Add New Pricing and Product
                                                                    Variation</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="menu-list">
                                                <li>
                                                    <a href="distributors.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-secondary">
                                                                <i class="ti ti-chart-arcs"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Distributors</p>
                                                                <span>Add New Distributors</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="dealers.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-tertiary">
                                                                <i class="ti ti-building-community"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Dealers</p>
                                                                <span>Add New Dealers</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="roles-permissions.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-success">
                                                                <i class="ti ti-navigation-cog"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Roles Permissions</p>
                                                                <span>Add New Role</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="manage-users.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-purple">
                                                                <i class="ti ti-users"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Manage Users</p>
                                                                <span>Add New Manage User</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="product-category.html">
                                                        <div class="menu-details">
                                                            <span class="menu-list-icon bg-info">
                                                                <i class="ti ti-medal"></i>
                                                            </span>
                                                            <div class="menu-details-content">
                                                                <p>Products Category</p>
                                                                <span>Add New Products Category</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="lead-reports.html" class="btn btn-chart-pie">
                                    <i class="ti ti-chart-pie"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- /Nav List -->
                    <!-- Notifications -->
                    <li class="nav-item dropdown nav-item-box">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="dropdown">
                            <i class="ti ti-bell"></i>
                            <span class="badge rounded-pill">13</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                            <div class="topnav-dropdown-header">
                                <h4 class="notification-title">Notifications</h4>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list">
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media d-flex">
                                                <span class="avatar flex-shrink-0">
                                                    <img src="images/avatar-14.png" alt="Profile">
                                                    <span class="badge badge-info rounded-pill"></span>
                                                </span>
                                                <div class="media-body flex-grow-1">
                                                    <p class="noti-details">Ray Arnold left 6 comments on Isla
                                                        Nublar SOC2 compliance report</p>
                                                    <p class="noti-time">Last Wednesday at 9:42 am</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media d-flex">
                                                <span class="avatar flex-shrink-0">
                                                    <img src="images/avatar-14.png" alt="Profile">
                                                </span>
                                                <div class="media-body flex-grow-1">
                                                    <p class="noti-details">Denise Nedry replied to Anna Srzand
                                                    </p>
                                                    <p class="noti-sub-details">“Oh, I finished de-bugging the
                                                        phones, but the system's compiling for eighteen minutes,
                                                        or twenty. So, some minor systems may go on and off for
                                                        a while.”</p>
                                                    <p class="noti-time">Last Wednesday at 9:42 am</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media d-flex">
                                                <span class="avatar flex-shrink-0">
                                                    <img alt="" src="images/avatar-14.png">
                                                </span>
                                                <div class="media-body flex-grow-1">
                                                    <p class="noti-details">John Hammond attached a file to
                                                        Isla Nublar SOC2 compliance report</p>
                                                    <div class="noti-pdf">
                                                        <div class="noti-pdf-icon">
                                                            <span><i class="ti ti-chart-pie"></i></span>
                                                        </div>
                                                        <div class="noti-pdf-text">
                                                            <p>EY_review.pdf</p>
                                                            <span>2mb</span>
                                                        </div>
                                                    </div>
                                                    <p class="noti-time">Last Wednesday at 9:42 am</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="order-management.html" class="view-link">View all</a>
                                <a href="javascript:void(0);" class="clear-link">Clear all</a>
                            </div>
                        </div>
                    </li>
                    <!-- /Notifications -->
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                            <span class="user-info">
                                <span class="user-letter">
                                    <img src="{{ asset('images/default-user.png') }}" alt="Profile">
                                </span>
                                <span class="badge badge-success rounded-pill"></span>
                            </span>
                        </a>
                        <div class="dropdown-menu menu-drop-user">
                            <div class="profilename">
                                <a class="dropdown-item" href="index.html">
                                    <i class="ti ti-layout-2"></i> Dashboard
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="ti ti-user-pin"></i> My Profile
                                </a>
                                {{-- <a class="dropdown-item" href="login.html">
                    <i class="ti ti-lock"></i> Logout
                    </a> --}}
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    <i class="ti ti-lock"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </li>
                    <!-- /Profile Dropdown -->
                </ul>
            </div>
            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="index.html">
                        <i class="ti ti-layout-2"></i> Dashboard
                    </a>
                    <a class="dropdown-item" href="profile.html">
                        <i class="ti ti-user-pin"></i> My Profile
                    </a>
                    <a class="dropdown-item" href="login.html">
                        <i class="ti ti-lock"></i> Logout
                    </a>

                </div>
            </div>
            <!-- /Mobile Menu -->
        </div>
        <!-- /Header -->
        <!-- Sidebar -->
        @auth
            @include('layouts.sidebar')
        @endauth
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <div class="row align-items-center ">
                                <div class="col-md-4">
                                    <h3 class="page-title">
                                        @yield('title')
                                    </h3>
                                </div>
                                {{-- <div class="col-md-8 float-end ms-auto">
                                    <div class="d-flex title-head">
                                        <div class="daterange-picker d-flex align-items-center justify-content-center">
                                            <div class="form-sort me-2">
                                                <i class="ti ti-calendar"></i>
                                                <input type="text" class="form-control  date-range bookingrange">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!-- only use dashboard Custom Json Js -->
    <!-- <script src="js/jsonscript.js"></script> -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/toastify.js') }}"></script>

    {{-- summernote --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    {{-- End summernote --}}

    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4fbe87",
            }).showToast();
        </script>
    @endif

    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#f27474",
            }).showToast();
        </script>
    @endif

    <script>
        function show_success(msg) {
            Toastify({
                text: msg,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4fbe87",
            }).showToast();
        }

        function show_error(msg) {
            Toastify({
                text: msg,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#f27474",
            }).showToast();
        }
    </script>
    @yield('script')
</body>

</html>
