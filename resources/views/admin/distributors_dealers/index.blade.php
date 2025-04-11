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
                                            class="ti ti-file-type-pdf text-danger me-1"></i>Export as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                            class="ti ti-file-type-xls text-green me-1"></i>Export as Excel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary"
                   data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i
                   class="ti ti-square-rounded-plus me-2"></i>Add Dealers</a> -->

                    {{-- <a href="#" class="btn btn-primary"><i class="ti ti-square-rounded-plus me-2"></i>Export Price List</a> --}}

                    <a href="{{ route('distributors_dealers.create',request('dealer')) }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i> {{ request('dealer') == 1 ? 'Add Dealers' : 'Add Distributors' }}</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- dealers Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="distributerTable">
                <thead class="thead-light">
                    <tr>
                        {{-- <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all"><span class="checkmarks"></span>
                            </label>
                        </th> --}}
                        <th class="no-sort" scope="col"></th>

                        <th scope="col"> {{ request('dealer') == 1 ? 'Dealer Name' : 'Distributor Name' }}</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Code</th>

                        <th class="text-end" scope="col">Action</th>
                    </tr>
                </thead>
                {{-- <tbody>
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
                </tbody> --}}
            </table>
        </div>

        <!-- /dealers Users List -->
    </div>
</div>

@endsection
@section('script')
<script>
    var distributors_dealers_table = $('#distributerTable').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('distributors_dealers.index', request('dealer')) }}",
        columns: [
            // {
            //        data: 'checkbox',
            //        name: 'checkbox',
            //        orderable: false,
            //        searchable: false
            //    },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'applicant_name',
                name: 'applicant_name',
                searchable: true
            },
            {
                data: 'mobile_no',
                name: 'mobile_no',
                searchable: true
            },
            {
                data: 'code_no',
                name: 'code_no',
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

    $(document).on('click', '.delete_d_d', function(event) {
        event.preventDefault();
        let d_d_Id = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + d_d_Id); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this record? Once deleted, it cannot be recovered.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'my-custom-popup',
                title: 'my-custom-title',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary',
                icon: 'my-custom-icon swal2-warning'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                callback(); // Execute callback function if confirmed
            }
        });
    }
</script>
@endsection
