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
                    <input type="text" class="form-control" id="customSearch" placeholder="Search">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                    <!--  <div class="dropdown me-2">
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
                </div> -->
                    <a href="{{ route('users.create') }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add user</a>
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
                <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown">
                   <i class="ti ti-sort-ascending-2 me-2"></i>Sort </a>
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
             <div class="icon-form">
                <span class="form-icon"><i class="ti ti-calendar"></i></span>
                <input type="text" class="form-control bookingrange" placeholder="">
             </div>
          </div>

       </div> --}}
        <!-- /Filter -->
        <!-- Manage Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="users">
                <thead class="thead-light">
                    <tr>
                        {{-- <th class="no-sort"  scope="col">
                      <label class="checkboxs"> <input type="checkbox" id="select-all"><span class="checkmarks"></span></label>
                   </th>  --}}
                        {{-- <th class="no-sort"  scope="col"></th> --}}
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                        <th scope="col">Last Activity</th>
                        <th scope="col">Status</th>
                        <th class="text-end" scope="col">Action</th>
                    </tr>
                </thead>
                {{-- <tbody>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs">
                      <input type="checkbox" id="select-all"><span class="checkmarks"></span></label>
                   </td>
                   <td data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Darlee Robertson <span class="text-default">Facility Manager </span></a></h2>
                   </td>
                   <td data-label="Phone">1234567890</td>
                   <td data-label="Email">robertson@example.com</td>
                   <td data-label="Role">Admin</td>
                   <td data-label="Created">25 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-danger">Inactive</span></td>
                   <td class="text-end" data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs">
                      <input type="checkbox" id="select-all"><span class="checkmarks"></span></label>
                   </td>
                   <td data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Sharon Roy<span class="text-default">Installer</span></a></h2>
                   </td>
                   <td data-label="Phone">+1 989757485</td>
                   <td data-label="Email">sharon@example.com</td>
                   <td data-label="Role">Company Owner</td>
                   <td data-label="Created">25 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-success">Active</span></td>
                   <td class="text-end"  data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td  data-label="Checkmark"><label class="checkboxs"> <input type="checkbox" id="select-all"><span class="checkmarks"></span> </label></td>
                   <td data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Darlee Robertson <span class="text-default">Vaughan Lewis </span></a></h2>
                   </td>
                   <td data-label="Phone">1235667890</td>
                   <td data-label="Email">vaughan12@example.com</td>
                   <td data-label="Role">Deal Owner</td>
                   <td data-label="Created">26 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-danger">Inactive</span></td>
                   <td class="text-end" data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span> </label></td>
                   <td data-label="Rating">
                      <div class="set-star rating-select"><i class="fa fa-star"></i></div>
                   </td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Jessica Louise<span class="text-default">Test Engineer</span></a></h2>
                   </td>
                   <td data-label="Phone">1224567890</td>
                   <td data-label="Email">robertson@example.com</td>
                   <td data-label="Role">Project Manager</td>
                   <td data-label="Created">27 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-success">Active</span></td>
                   <td class="text-end" data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label>
                   </td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div></td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Darlee Robertson <span class="text-default">Vaughan Lewis </span></a></h2>
                   </td>
                   <td data-label="Phone">1235667890</td>
                   <td data-label="Email">vaughan12@example.com</td>
                   <td data-label="Role">Client</td>
                   <td data-label="Created">26 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-success">Active</span></td>
                   <td class="text-end" data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div> </td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Jessica Louise<span class="text-default">Test Engineer</span></a></h2>
                   </td>
                   <td data-label="Phone">1224567890</td>
                   <td data-label="Email">robertson@example.com</td>
                   <td data-label="Role">Admin</td>
                   <td data-label="Created">27 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-success">Active</span></td>
                   <td class="text-end" data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs">
                      <input type="checkbox" id="select-all"><span class="checkmarks"></span></label>
                   </td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div></td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Darlee Robertson <span class="text-default">Vaughan Lewis </span></a></h2>
                   </td>
                   <td data-label="Phone">1235667890</td>
                   <td data-label="Email">vaughan12@example.com</td>
                   <td data-label="Role">Project Manager</td>
                   <td data-label="Created">26 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-success">Active</span></td>
                   <td class="text-end" data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
                <tr>
                   <td data-label="Checkmark"><label class="checkboxs"><input type="checkbox" id="select-all"><span class="checkmarks"></span></label></td>
                   <td data-label="Rating"><div class="set-star rating-select"><i class="fa fa-star"></i></div></td>
                   <td data-label="Name">
                      <h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="images/avatar-14.png" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">Jessica Louise<span class="text-default">Test Engineer</span></a></h2>
                   </td>
                   <td data-label="Phone">1224567890</td>
                   <td data-label="Email">robertson@example.com</td>
                   <td data-label="Role">Deal Owner</td>
                   <td data-label="Created">27 Sep 2023, 12:12 pm</td>
                   <td data-label="Last Activity">2 mins ago</td>
                   <td data-label="Status"><span class="badge badge-pill badge-status bg-success">Active</span></td>
                   <td class="text-end"  data-label="Action">
                      <div class="dropdown table-action">
                         <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-manage-users.html"><i class="ti ti-edit text-blue"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a>
                         </div>
                      </div>
                   </td>
                </tr>
             </tbody> --}}
            </table>
        </div>

        <!-- /Manage Users List -->
    </div>
</div>
<!--  Single Modal for Add & Edit -->
<div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="adminForm">
                    @csrf
                    <input type="hidden" name="user_id">

                    <div class="mb-3">
                        <label>First Name:</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter first name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Last Name:</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter last name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone:</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone">
                    </div>

                    <div class="mb-3">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Re-enter password">
                    </div>
                    <div class="float-end">
                        <button type="submit" class="bntsize table-sm-btn big-btn blackbg" id="submitBtn">Save</button>
                        <button type="button" class="bntsize table-sm-btn big-btn redbg"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary" id="submitBtn">Create</button> --}}
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    //  $(document).ready(function() {
    //      $('#users').DataTable({
    //          "searching": false,
    //          "paging": false,
    //          "ordering": true,
    //           "info": false,

    //      });
    //  });

    var users_table = $('#users').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('users.index') }}",
        columns: [{
                data: 'name',
                name: 'name',
                searchable: true
            },
            {
                data: 'phone_no',
                name: 'phone_no',
                searchable: true
            },
            {
                data: 'email',
                name: 'email',
                searchable: true
            },
            {
                data: 'role',
                name: 'role',
                searchable: true
            },
            {
                data: 'created_at',
                name: 'created_at',
                searchable: true
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                searchable: true
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

    // Custom Search Box
    $('#customSearch').on('keyup', function() {
        users_table.search(this.value).draw();
    });

    //  Open Modal for Adding a New Admin
    $('#openModal').click(function() {
        $('#modalTitle').text('Add Admin');
        $('#submitBtn').text('Create');
        $('#adminForm')[0].reset();
        $('input[name="user_id"]').val('');
        $('#adminModal').modal('show');
    });

    //  Open Modal for Editing an Admin
    $(document).on('click', '.edit-btn', function() {
        let user_id = $(this).data('id');
        $.get('{{ route('users.edit', ':id') }}'.replace(':id', user_id), function(user) {
            $('#modalTitle').text('Edit Admin');
            $('#submitBtn').text('Update');
            $('input[name="user_id"]').val(user.id);
            $('input[name="first_name"]').val(user.first_name);
            $('input[name="last_name"]').val(user.last_name);
            $('input[name="email"]').val(user.email);
            $('input[name="phone"]').val(user.phone);
            $('#adminModal').modal('show');
        });
    });

    //  Handle Add & Edit Form Submission
    $('#adminForm').submit(function(e) {
        e.preventDefault();
        let user_id = $('input[name="user_id"]').val();
        let url = user_id ? '{{ route('users.update', ':id') }}'.replace(':id', user_id) :
            "{{ route('users.store') }}";
        let method = user_id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize() + "&_method=" + method,
            success: function(response) {
                $('#adminModal').modal('hide');
                users_table.ajax.reload();
                show_success(response.message);
            },
            error: function(response) {
                show_error('Error occurred!');
            }
        });
    });

    $(document).on('click', '.deleteUser', function(event) {
    event.preventDefault();
        let userId = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + userId); // Select the correct form
        console.log(form);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this user? Once deleted, it cannot be recovered.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'my-custom-popup', // Custom class for the popup
                title: 'my-custom-title', // Custom class for the title
                confirmButton: 'btn btn-primary', // Custom class for the confirm button
                cancelButton: 'btn btn-secondary', // Custom class for the cancel button
                icon: 'my-custom-icon swal2-warning'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form if confirmed
            }
        });
    });

    // $(".dataTables_filter").hide();
    // $(".dataTables_length").hide();
</script>
@endsection
