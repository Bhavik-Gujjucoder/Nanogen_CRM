@extends('layouts.main')
@section('content')
@section('title')
<!-- {{ $page_title }} -->
@endsection

{{-- HTML code Write hear..... --}}
<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h4 class="page-title">Payments</h4>
                        </div>
                        <div class="col-8 text-end">
                            <div class="head-icons">
                                <a href="payments.html" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Refresh">
                                    <i class="ti ti-refresh-dot"></i>
                                </a>
                                <a href="" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Collapse" id="collapse-header">
                                    <i class="ti ti-chevrons-up"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">

                    <div class="card-header">
                        <!-- Search -->
                        <div class="row align-items-center">
                            <div class="col-sm-4">
                                <div class="icon-form mb-3 mb-sm-0">
                                    <span class="form-icon"><i class="ti ti-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Search Payments">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div
                                    class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end mb-3 mb-sm-0">
                                    <div class="dropdown me-2">
                                        <a href="" class="dropdown-toggle"
                                            data-bs-toggle="dropdown"><i
                                                class="ti ti-package-export me-2"></i>Export</a>
                                        <div class="dropdown-menu  dropdown-menu-end">
                                            <ul>
                                                <li>
                                                    <a href="" class="dropdown-item"><i
                                                            class="ti ti-file-type-pdf text-danger me-1"></i>Export
                                                        as PDF</a>
                                                </li>
                                                <li>
                                                    <a href="" class="dropdown-item"><i
                                                            class="ti ti-file-type-xls text-green me-1"></i>Export
                                                        as Excel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Search -->
                    </div>

                    <div class="card-body">

                        <!-- Filter -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 row-gap-2">
                            <div class="d-flex align-items-center flex-wrap row-gap-2">
                                <div class="dropdown me-2">
                                    <a href="" class="dropdown-toggle"
                                        data-bs-toggle="dropdown"><i
                                            class="ti ti-sort-ascending-2 me-2"></i>Sort </a>
                                    <div class="dropdown-menu  dropdown-menu-start">
                                        <ul>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i class="ti ti-circle-chevron-right me-1"></i>Ascending
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i class="ti ti-circle-chevron-right me-1"></i>Descending
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i class="ti ti-circle-chevron-right me-1"></i>Recently
                                                    Viewed
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i class="ti ti-circle-chevron-right me-1"></i>Recently
                                                    Added
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="icon-form">
                                    <span class="form-icon"><i class="ti ti-calendar"></i></span>
                                    <input type="text" class="form-control bookingrange" placeholder="">
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-wrap row-gap-2">
                                <div class="dropdown me-2">
                                    <a href="" class="btn bg-soft-purple text-purple"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside"><i
                                            class="ti ti-columns-3 me-2"></i>Manage Columns</a>
                                    <div class="dropdown-menu  dropdown-menu-md-end dropdown-md p-3">
                                        <h4 class="mb-2 fw-semibold">Want to manage datatables?</h4>
                                        <p class="mb-3">Please drag and drop your column to reorder your table
                                            and enable see option as you want.</p>
                                        <div class="border-top pt-3">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Order ID</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-name" class="check">
                                                    <label for="col-name" class="checktoggle"></label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Customer Name</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-phone" class="check">
                                                    <label for="col-phone" class="checktoggle"></label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Order Date</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-email" class="check">
                                                    <label for="col-email" class="checktoggle"></label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Due Date</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-tag" class="check">
                                                    <label for="col-tag" class="checktoggle"></label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Amount</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-loc" class="check">
                                                    <label for="col-loc" class="checktoggle"></label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Paid Amount</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-rate" class="check">
                                                    <label for="col-rate" class="checktoggle"></label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Due Amount</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-rate" class="check">
                                                    <label for="col-rate" class="checktoggle"></label>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0 d-flex align-items-center"><i
                                                        class="ti ti-grip-vertical me-2"></i>Action</p>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="col-action" class="check">
                                                    <label for="col-action" class="checktoggle"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-sorts dropdown">
                                    <a href="" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside"><i
                                            class="ti ti-filter-share"></i>Filter</a>
                                    <div class="filter-dropdown-menu dropdown-menu  dropdown-menu-md-end p-4">
                                        <div class="filter-set-view">
                                            <div class="filter-set-head">
                                                <h4><i class="ti ti-filter-share"></i>Filter</h4>
                                            </div>
                                            <div class="accordion" id="accordionExample">
                                                <div class="filter-set-content">
                                                    <div class="filter-set-content-head">
                                                        <a href="#" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse" aria-expanded="true"
                                                            aria-controls="collapse">Order ID</a>
                                                    </div>
                                                    <div class="filter-set-contents accordion-collapse collapse show"
                                                        id="collapse" data-bs-parent="#accordionExample">
                                                        <div class="filter-content-list">
                                                            <div class="mb-2 icon-form">
                                                                <span class="form-icon"><i
                                                                        class="ti ti-search"></i></span>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Search ID">
                                                            </div>
                                                            <ul>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            #1254058
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            #1254057
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            #1254056
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            #1254055
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            #1254054
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="filter-set-content">
                                                    <div class="filter-set-content-head">
                                                        <a href="#" class="collapsed" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseone" aria-expanded="false"
                                                            aria-controls="collapseone">Due Date</a>
                                                    </div>
                                                    <div class="filter-set-contents accordion-collapse collapse"
                                                        id="collapseone" data-bs-parent="#accordionExample">
                                                        <div class="filter-content-list">
                                                            <ul>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox" checked>
                                                                            <span class="checkmarks"></span>
                                                                            15 Oct 2023
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            19 Oct 2023
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            24 Oct 2023
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            10 Nov 2023
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            18 Nov 2023
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="filter-set-content">
                                                    <div class="filter-set-content-head">
                                                        <a href="#" class="collapsed" data-bs-toggle="collapse"
                                                            data-bs-target="#collapsethree"
                                                            aria-expanded="false"
                                                            aria-controls="collapsethree">Amount</a>
                                                    </div>
                                                    <div class="filter-set-contents accordion-collapse collapse"
                                                        id="collapsethree" data-bs-parent="#accordionExample">
                                                        <div class="filter-content-list">
                                                            <div class="mb-2 icon-form">
                                                                <span class="form-icon"><i
                                                                        class="ti ti-search"></i></span>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Search Amount">
                                                            </div>
                                                            <ul>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox" checked>
                                                                            <span class="checkmarks"></span>
                                                                            2,00,000
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            2,00,000
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            2,00,000
                                                                        </label>
                                                                    </div>

                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            2,00,000
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="filter-checks">
                                                                        <label class="checkboxs">
                                                                            <input type="checkbox">
                                                                            <span class="checkmarks"></span>
                                                                            2,00,000
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="filter-reset-btns">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-light">Reset</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="payments.html"
                                                            class="btn btn-primary">Filter</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Filter -->

                        <!-- Projects List -->
                        <div class="table-responsive custom-table">
                            <table class="table" id="payments-list">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Order Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd">
                                        <td class="sorting_1"><a href="#" class="title-name">#1254049</a></td>
                                        <td>
                                            <h2 class="d-flex align-items-center"><a href="">NovaWave LLC</a></h2>
                                        </td>

                                        <td>28 Dec 2023</td>
                                        <td>28 Dec 2023</td>
                                        <td>2,00,000</td>
                                        <td>2,00,000</td>
                                        <td>2,00,000</td>
                                        <td><span class="badge badge-pill badge-status bg-danger">Pending</span></td>
                                        <td>
                                            <div class="dropdown table-action">
                                                <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="fa fa-plus" aria-hidden="true"></i> Add </a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_payments"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="even">
                                        <td class="sorting_1"><a href="#" class="title-name">#1254049</a></td>
                                        <td>
                                            <h2 class="d-flex align-items-center"><a href="">NovaWave LLC</a></h2>
                                        </td>

                                        <td>28 Dec 2023</td>
                                        <td>28 Dec 2023</td>
                                        <td>2,00,000</td>
                                        <td>2,00,000</td>
                                        <td>2,00,000</td>
                                        <td><span class="badge badge-pill badge-status bg-success">Under review</span></td>
                                        <td>
                                            <div class="dropdown table-action">
                                                <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="fa fa-plus" aria-hidden="true"></i> Add</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_payments"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="sorting_1"><a href="#" class="title-name">#1254049</a></td>
                                        <td>
                                            <h2 class="d-flex align-items-center"><a href="">NovaWave LLC</a></h2>
                                        </td>

                                        <td>28 Dec 2023</td>
                                        <td>28 Dec 2023</td>
                                        <td>2,00,000</td>
                                        <td>2,00,000</td>
                                        <td>2,00,000</td>
                                        <td><span class="badge badge-pill badge-status bg-purple">In Progress</span></td>
                                        <td>
                                            <div class="dropdown table-action">
                                                <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="fa fa-plus" aria-hidden="true"></i> Add</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_payments"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="datatable-length"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="datatable-paginate"></div>
                            </div>
                        </div>
                        <!-- /Projects List -->

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@section('script')
<script>

</script>
@endsection