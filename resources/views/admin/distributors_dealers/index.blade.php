@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-header">
        <!-- Search -->
        <div class="row align-items-center">
            <div class="col-sm-4">
                <div class="icon-form mb-3 mb-sm-0">
                    <span class="form-icon"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search User">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="d-flex align-items-center flex-wrap row-gap-2 column-gap-1 justify-content-sm-end">
                    <div class="dropdown me-2">
                        <!-- <a href="javascript:void(0);" class="dropdown-toggle"
                      data-bs-toggle="dropdown"><i
                      class="ti ti-package-export me-2"></i>Export</a> -->
                        <div class="dropdown-menu  dropdown-menu-end">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                            class="ti ti-file-type-pdf text-danger me-1"></i>Export
                                        as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                            class="ti ti-file-type-xls text-green me-1"></i>Export
                                        as Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary"
                   data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i
                   class="ti ti-square-rounded-plus me-2"></i>Add Dealers</a> -->

                    <a href="#" class="btn btn-primary"><i class="ti ti-square-rounded-plus me-2"></i>Export Price
                        List</a>

                    <a href="{{route('distributors_dealers.create')}}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add Distributors</a>


                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">
            <div class="d-flex align-items-center flex-wrap row-gap-2">
                <div class="dropdown me-2">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="ti ti-sort-ascending-2 me-2"></i>Sort </a>
                    <div class="dropdown-menu  dropdown-menu-start">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="ti ti-circle-chevron-right me-1"></i>Ascending
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="ti ti-circle-chevron-right me-1"></i>Descending
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="ti ti-circle-chevron-right me-1"></i>Recently
                                    Viewed
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="ti ti-circle-chevron-right me-1"></i>Recently
                                    Added
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--   <div class="icon-form">
                <span class="form-icon"><i class="ti ti-calendar"></i></span>
                <input type="text" class="form-control bookingrange" placeholder="">
             </div> -->
            </div>
            <!--  <div class="d-flex align-items-center flex-wrap row-gap-2">
             <div class="form-sorts dropdown">
                <a href="javascript:void(0);" data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"><i
                   class="ti ti-filter-share"></i>Filter</a>
                <div class="filter-dropdown-menu dropdown-menu  dropdown-menu-md-end p-3">
                   <div class="filter-set-view">
                      <div class="filter-set-head">
                         <h4><i class="ti ti-filter-share"></i>Filter</h4>
                      </div>
                      <div class="accordion" id="accordionExample">
                         <div class="filter-set-content">
                            <div class="filter-set-content-head">
                               <a href="#" data-bs-toggle="collapse"
                                  data-bs-target="#collapseTwo" aria-expanded="true"
                                  aria-controls="collapseTwo">Name</a>
                            </div>
                            <div class="filter-set-contents accordion-collapse collapse show"
                               id="collapseTwo" data-bs-parent="#accordionExample">
                               <div class="filter-content-list">
                                  <div class="mb-2 icon-form">
                                     <span class="form-icon"><i
                                        class="ti ti-search"></i></span>
                                     <input type="text" class="form-control"
                                        placeholder="Search Name">
                                  </div>
                                  <ul>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           Darlee Robertson
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           Sharon Roy
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           Vaughan Lewis
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           Jessica Louise
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           Carol Thomas
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
                                  data-bs-target="#phone" aria-expanded="false"
                                  aria-controls="phone">Phone</a>
                            </div>
                            <div class="filter-set-contents accordion-collapse collapse"
                               id="phone" data-bs-parent="#accordionExample">
                               <div class="filter-content-list">
                                  <ul>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           +1 875455453
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           +1 989757485
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           +1 546555455
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
                                  data-bs-target="#email" aria-expanded="false"
                                  aria-controls="email">Email</a>
                            </div>
                            <div class="filter-set-contents accordion-collapse collapse"
                               id="email" data-bs-parent="#accordionExample">
                               <div class="filter-content-list">
                                  <ul>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           robertson@example.com
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           sharon@example.com
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           vaughan12@example.com
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
                                  data-bs-target="#location" aria-expanded="false"
                                  aria-controls="location">Location</a>
                            </div>
                            <div class="filter-set-contents accordion-collapse collapse"
                               id="location" data-bs-parent="#accordionExample">
                               <div class="filter-content-list">
                                  <ul>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           Germany
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           USA
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           Canada
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
                                  data-bs-target="#owner" aria-expanded="false"
                                  aria-controls="owner">Created Date</a>
                            </div>
                            <div class="filter-set-contents accordion-collapse collapse"
                               id="owner" data-bs-parent="#accordionExample">
                               <div class="filter-content-list">
                                  <ul>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           25 Sep 2023, 12:12 pm
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           27 Sep 2023, 07:40 am
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           29 Sep 2023, 08:20 am
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           02 Oct 2023, 10:10 am
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox">
                                           <span class="checkmarks"></span>
                                           17 Oct 2023, 04:25 pm
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
                                  data-bs-target="#Status" aria-expanded="false"
                                  aria-controls="Status">Status</a>
                            </div>
                            <div class="filter-set-contents accordion-collapse collapse"
                               id="Status" data-bs-parent="#accordionExample">
                               <div class="filter-content-list">
                                  <ul>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           Active
                                           </label>
                                        </div>
                                     </li>
                                     <li>
                                        <div class="filter-checks">
                                           <label class="checkboxs">
                                           <input type="checkbox" checked>
                                           <span class="checkmarks"></span>
                                           Inactive
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
                               <a href="manage-users.html"
                                  class="btn btn-primary">Filter</a>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div> -->
        </div>
        <!-- /Filter -->
        <!-- dealers Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="distributerTable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all"><span class="checkmarks"></span>
                            </label>
                        </th>
                        <th class="no-sort" scope="col"></th>
                        <th scope="col">Distributer Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Dealer Form</th>
                        <th scope="col">O form</th>
                        <th scope="col">Firm Name</th>
                        <th class="text-end" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox"
                                    id="select-all"><span class="checkmarks"></span> </label>
                        </td>
                        <td data-label="Rating">
                            <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                        </td>
                        <td data-label="Distributer Name">
                            <h2 class="d-flex align-items-center"><a href="javascript:void(0);"
                                    class="avatar avatar-sm me-2"><img class="w-auto h-auto"
                                        src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);"
                                    class="d-flex flex-column">Darlee Robertson <span class="text-default">Facility
                                        Manager </span></a></h2>
                        </td>
                        <td data-label="Phone">0123456789</td>
                        <td data-label="Email">info@gmail.com</td>

                        <td data-label="Dealer Form">Yes</td>
                        <td data-label="O form">Yes</td>
                        <td data-label="Firm Name">abcd</td>
                        <td class="text-end" data-label="Action">
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon " data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                        href="edit-distributors.html"><i class="ti ti-edit text-blue"></i> Edit</a><a
                                        class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i>
                                        Delete</a></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Checkmark"><label class="checkboxs">
                                <input type="checkbox" id="select-all"><span class="checkmarks"></span>
                            </label>
                        </td>
                        <td data-label="Rating">
                            <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                        </td>
                        <td data-label="Distributer Name">
                            <h2 class="d-flex align-items-center"><a href="javascript:void(0);"
                                    class="avatar avatar-sm me-2"><img class="w-auto h-auto"
                                        src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);"
                                    class="d-flex flex-column"> Konopelski<span class="text-default">Facility Manager
                                    </span></a></h2>
                        </td>
                        <td data-label="Phone">0123456789</td>
                        <td data-label="Email">info@gmail.com</td>

                        <td data-label="Dealer Form">Yes</td>
                        <td data-label="O form">No</td>
                        <td data-label="Firm Name">abcd</td>
                        <td class="text-end" data-label="Action">
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon " data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                        href="edit-distributors.html"><i class="ti ti-edit text-blue"></i> Edit</a><a
                                        class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i>
                                        Delete</a></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Checkmark"><label class="checkboxs"> <input type="checkbox"
                                    id="select-all"><span class="checkmarks"></span></label> </td>
                        <td data-label="Rating">
                            <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                        </td>
                        <td data-label="Distributer Name">
                            <h2 class="d-flex align-items-center"><a href="javascript:void(0);"
                                    class="avatar avatar-sm me-2"><img class="w-auto h-auto"
                                        src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);"
                                    class="d-flex flex-column">Wisozk<span class="text-default">Facility Manager
                                    </span></a></h2>
                        </td>
                        <td data-label="Phone">0123456789</td>
                        <td data-label="Email">info@gmail.com</td>

                        <td data-label="Dealer Form">No</td>
                        <td data-label="O form">Yes</td>
                        <td data-label="Firm Name">abcd</td>
                        <td class="text-end" data-label="Action">
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon " data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                        href="edit-distributors.html"><i class="ti ti-edit text-blue"></i> Edit</a><a
                                        class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i>
                                        Delete</a></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="datatable-length">
                    <div class="dataTables_length" id="leads_list_length">
                        <label>
                            Show
                            <select name="leads_list_length" aria-controls="leads_list"
                                class="form-select form-select-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            entries
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="datatable-paginate">
                    <div class="dataTables_paginate paging_simple_numbers" id="leads_list_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="leads_list_previous"><a
                                    aria-controls="leads_list" aria-disabled="true" role="link"
                                    data-dt-idx="previous" tabindex="-1" class="page-link"><i
                                        class="fa fa-angle-left"></i> Prev </a></li>
                            <li class="paginate_button page-item active"><a href="#" aria-controls="leads_list"
                                    role="link" aria-current="page" data-dt-idx="0" tabindex="0"
                                    class="page-link">1</a></li>
                            <li class="paginate_button page-item next disabled" id="leads_list_next"><a
                                    aria-controls="leads_list" aria-disabled="true" role="link"
                                    data-dt-idx="next" tabindex="-1" class="page-link">Next <i
                                        class=" fa fa-angle-right"></i> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /dealers Users List -->
    </div>
</div>

@endsection
@section('script')
<script></script>
@endsection
