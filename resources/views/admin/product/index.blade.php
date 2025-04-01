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
                <input type="text" class="form-control" id="customSearch" placeholder="Search Leads">
             </div>
          </div>
          <div class="col-sm-8">
             <div
                class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">

                {{-- <div class="dropdown me-2">
                   <a href="javascript:void(0);" class="dropdown-toggle"
                      data-bs-toggle="dropdown"><i
                      class="ti ti-package-export me-2"></i>Export</a>
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
                </div> --}}

                <!-- <a href="javascript:void(0);" class="btn btn-primary"
                   data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i
                   class="ti ti-square-rounded-plus me-2"></i>Add Catalogue</a> -->

                   <a href="{{ route('product.create') }}" class="btn btn-primary"><i
                   class="ti ti-square-rounded-plus me-2"></i>Add Catalogue</a>
             </div>
          </div>
       </div>
       <!-- /Search -->
    </div>
    <div class="card-body">
       <!-- Filter -->
       {{-- <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">
          <div class="d-flex align-items-center flex-wrap row-gap-2">
             <div class="dropdown me-2">
                <a href="javascript:void(0);" class="dropdown-toggle"
                   data-bs-toggle="dropdown"><i
                   class="ti ti-sort-ascending-2 me-2"></i>Sort
                </a>
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
             <!-- <div class="icon-form">
                <span class="form-icon"><i class="ti ti-calendar"></i></span>
                <input type="text" class="form-control bookingrange" placeholder="">
             </div> -->
          </div>

       </div> --}}
       <!-- /Filter -->

       <!-- List -->
       <div class="table-responsive custom-table">
          <table class="table" id="product_table">
             <thead class="thead-light">
                <tr>
                   <th class="no-sort" scope="col"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></th>
                   <th class="no-sort" scope="col"></th>
                   <th scope="col">Product Name</th>
                   <th scope="col">Category</th>
                   <th scope="col">Grade</th>
                   <th scope="col">Status</th>
                   {{-- <th scope="col">Available Packages</th>
                   <th scope="col">Price</th> --}}
                   <th class="no-sort" scope="col">Action</th>
                </tr>
             </thead>
             {{-- <tbody>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div></td>
                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-1.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">Mono Potassium Phosphate<span class="text-default"></span></a>
                      </h2>
                   </td>
                   <td data-label="Category"><a href="#" class="title-name">Water Soluble Fertilizer</a></td>
                   <td data-label="Grade">Grade 1</td>
                   <td data-label="Available Packages">1 L, 500 ML, 1 KG, 5 KG</td>
                   <td data-label="Price">100</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a>
                            <!-- <a class="dropdown-item" href="#">
                            <i class="ti ti-clipboard-copy text-blue-light"></i> Clone</a> -->
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div></td>
                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-2.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">BlueSky Industries<span class="text-default"></span></a>
                      </h2>
                   </td>
                   <td data-label="Category"><a href="#" class="title-name">Mono Potassium Phosphate</a></td>
                   <td data-label="Grade">Grade 2</td>
                   <td data-label="Available Packages">1 L, 500 ML</td>
                   <td data-label="Price">200</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a>
                            <!-- <a class="dropdown-item" href="#"><i class="ti ti-clipboard-copy text-blue-light"></i> Clone</a> -->
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div></td>
                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-3.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">SilverHawk<span class="text-default"></span></a>
                      </h2>
                   </td>
                    <td data-label="Category"><a href="#" class="title-name">NPK</a></td>
                    <td data-label="Grade">Grade 3</td>
                    <td data-label="Available Packages"> 1 KG, 5 KG</td>
                    <td data-label="Price">300</td>
                    <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td  data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>

                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-4.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">SummitPeak<span class="text-default"></span></a>
                      </h2>
                   </td>
                   <td data-label="Category"><a href="#" class="title-name">Calcium Nitrate</a></td>
                   <td data-label="Grade">Grade 4</td>
                   <td data-label="Available Packages">1 L, 500 ML, 1 KG, 5 KG</td>
                   <td data-label="Price">400</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td  data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>

                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-5.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">NPK 100% Water Soluble Fertilizer Range<span class="text-default"></span></a>
                      </h2>
                   </td>
                   <td data-label="Category"><a href="#" class="title-name">Potassium Sulphate</a></td>
                   <td data-label="Grade">Grade 5</td>
                   <td data-label="Available Packages">1 KG</td>
                   <td data-label="Price">500</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>

                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-6.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">RiverStone Ventur<span class="text-default"></span></a>
                      </h2>
                   </td>
                   <td data-label="Category"><a href="#" class="title-name">Potassium Schoenite</a></td>
                   <td data-label="Grade">Grade 6</td>
                   <td data-label="Available Packages">1 L, 500 ML, 1 KG, 5 KG</td>
                   <td data-label="Price">600</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td  data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>

                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-7.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">CoastalStar Co.<span class="text-default"></span></a>
                      </h2>
                   </td>
                    <td data-label="Category"><a href="#" class="title-name">Bright Bridge Grp</a></td>
                    <td data-label="Grade">Grade 7</td>
                    <td data-label="Available Packages">5 KG</td>
                    <td data-label="Price">700</td>
                    <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td  data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>

                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-8.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">Golden Gate Ltd<span class="text-default"></span></a>
                      </h2>
                   </td>
                    <td data-label="Category"><a href="#" class="title-name">Potassium Nitrate</a></td>
                    <td data-label="Grade">Grade 8</td>
                    <td data-label="Available Packages">1 L, 500 ML, 1 KG, 5 KG</td>
                   <td data-label="Price">800</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td  data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>

                   <td data-label="Product Name">
                      <h2 class="d-flex align-items-center">
                         <a href="" class="avatar avatar-sm border rounded p-1 me-2">
                         <img class="w-auto h-auto" src="images/water-soluble-fertilizer-pro-1.jpg" alt="User Image"></a>
                         <a href="" class="d-flex flex-column">Redwood Inc<span class="text-default"></span></a>
                      </h2>
                   </td>
                   <td data-label="Category"><a href="#" class="title-name">Potassium Nitrate</a></td>
                   <td data-label="Grade">Grade 9</td>
                   <td data-label="Available Packages">1 L, 500 ML</td>
                   <td data-label="Price">100</td>
                   <td data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit-product-catelog.html"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash text-danger"></i> Delete</a></div>
                      </div>
                   </td>
                </tr>
             </tbody> --}}
          </table>
       </div>

       {{-- <div class="row align-items-center">
          <div class="col-md-6">
             <div class="datatable-length">
                <div class="dataTables_length" id="leads_list_length">
                   <label>
                      Show
                      <select name="leads_list_length" aria-controls="leads_list" class="form-select form-select-sm">
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
                      <li class="paginate_button page-item previous disabled" id="leads_list_previous"><a aria-controls="leads_list" aria-disabled="true" role="link" data-dt-idx="previous" tabindex="-1" class="page-link"><i class="fa fa-angle-left"></i> Prev </a></li>
                      <li class="paginate_button page-item active"><a href="#" aria-controls="leads_list" role="link" aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">1</a></li>
                      <li class="paginate_button page-item next disabled" id="leads_list_next"><a aria-controls="leads_list" aria-disabled="true" role="link" data-dt-idx="next" tabindex="-1" class="page-link">Next <i class=" fa fa-angle-right"></i> </a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div> --}}
       <!-- /List -->

    </div>
 </div>

@endsection
@section('script')
<script>
     /***** DataTable *****/
     var product_table_show = $('#product_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('product.index') }}",
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false

            }, {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, // Auto-increment number
            {
                data: 'product_name',
                name: 'product_name',
                searchable: true
            },
            {
                data: 'category_id',
                name: 'category_id',
                searchable: true,
                orderable: false
            },
            {
                data: 'grade_id',
                name: 'grade_id',
                searchable: true,
                orderable: false
            },
            {
                data: 'status',
                name: 'status',
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],

    });

    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        product_table_show.search(this.value).draw();
    });
 </script>
@endsection
