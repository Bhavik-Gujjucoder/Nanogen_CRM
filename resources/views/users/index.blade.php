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
                            class="ti ti-square-rounded-plus me-2"></i>Add User</a>
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
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="user_checkbox"><span class="checkmarks"></span>
                            </label>
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                        {{-- <th scope="col">Last Activity</th> --}}
                        <th scope="col">Status</th>
                        <th class="" scope="col">Action</th>
                    </tr>
                </thead>
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
    var users_table = $('#users').DataTable({
        "pageLength": 10,
        deferRender: true,
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [[0, 'desc']],  
        ajax: "{{ route('users.index') }}",
        columns: [
            { data: 'id', name: 'id', visible: false, searchable: false },
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
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
            // {
            //     data: 'updated_at',
            //     name: 'updated_at',
            //     searchable: true
            // },
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

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });

        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "You want to remove this user? Once deleted, it cannot be recovered.",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: 'Yes, delete it!',
        //     cancelButtonText: 'Cancel',
        //     customClass: {
        //         popup: 'my-custom-popup', // Custom class for the popup
        //         title: 'my-custom-title', // Custom class for the title
        //         confirmButton: 'btn btn-primary', // Custom class for the confirm button
        //         cancelButton: 'btn btn-secondary', // Custom class for the cancel button
        //         icon: 'my-custom-icon swal2-warning'
        //     }
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         form.submit(); // Submit form if confirmed
        //     }
        // });
    });

     /***** Bulk Delete *****/
     $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.user_checkbox').prop('checked', this.checked);

    });

    $(document).on('change', '.user_checkbox', function () {
        let count = $('.user_checkbox:checked').length; // Count checked checkboxes
        $('#checked-count').text(count); // Display count in an element
        if(count > 0){
            $('#bulk_delete_button').show();
        }else{
            $('#bulk_delete_button').hide();
        }
    });

    // Handle Bulk Delete button click
    $('#bulk_delete_button').click(function() {
       confirmDeletion(function() {
            var selectedIds = $('.user_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('user.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        users_table.ajax.reload();
                        // location.reload();
                        $('#bulk_delete_button').hide();
                    },
                    error: function(xhr, status, error) {
                        show_error('An error occurred while deleting.');
                        // alert("An error occurred while deleting.");
                    }
                });
            } else {
                alert("No items selected.");
            }
        });
        // Get the IDs of selected checkboxes
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this User? Once deleted, it cannot be recovered.",
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
