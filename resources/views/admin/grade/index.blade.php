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

                    <a href="javascript:void(0)" id="openModal" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add Grade</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- Manage Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="users">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="grade_checkbox"><span
                                    class="checkmarks"></span>
                            </label>
                        </th>
                        <th class="no-sort" scope="col"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                        {{-- class="text-end" --}}
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
                <h5 class="modal-title" id="modalTitle">Grade Management</h5>
                {{-- <button type="button" class="btn-close close_poup" data-bs-dismiss="modal"></button> --}}
                <button class="btn-close custom-btn-close border p-1 me-0 text-dark" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>

            </div>
            <div class="modal-body">
                <form id="adminForm">
                    @csrf
                    <input type="hidden" name="user_id">

                    <div class="mb-3">
                        <label class="col-form-label">Grade Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Grade name">
                        <span class="name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">Status</label>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <input type="radio" class="status-radio" id="active1" name="status" value="1"
                                    {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                <label for="active1">Active</label>
                            </div>
                            <div>
                                <input type="radio" class="status-radio" id="inactive1" name="status" value="0"
                                    {{ old('status') == '0' ? 'checked' : '' }}>
                                <label for="inactive1">Inactive</label>
                            </div>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="float-end">
                        <button type="button" class="btn btn-light me-2 close_poup"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var grade_table = $('#users').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [[0, 'desc']],  
        ajax: "{{ route('grade.index') }}",
        columns: [
            { data: 'id', name: 'id', visible: false, searchable: false },
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            // {
            //     data: 'id',
            //     name: 'id',
            //     searchable: true
            // },
            {
                data: 'name',
                name: 'name',
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


    /*** Custom Search Box ***/
    $('#customSearch').on('keyup', function() {
        grade_table.search(this.value).draw();
    });


    /***  Open Modal for Adding a New Grade ***/
    $('#openModal').click(function() {
        $('#adminForm')[0].reset();
        $('#modalTitle').text('Grade Management');
        $('#submitBtn').text('Create');
        $('input[name="user_id"]').val('');
        $('#adminModal').modal('show');
        $("#adminForm .text-danger").text('');
        $('#adminForm').find('.is-invalid').removeClass('is-invalid');

    });


    /***  Open Modal for Editing an Admin ***/
    $(document).on('click', '.edit-btn', function() {
        let user_id = $(this).data('id');
        $("#adminForm .text-danger").text('');
        $('#adminForm').find('.is-invalid').removeClass('is-invalid');

        $.get('{{ route('grade.edit', ':id') }}'.replace(':id', user_id), function(user) {
            $('#modalTitle').text('Edit Grade Management');
            $('#submitBtn').text('Update');
            $('input[name="user_id"]').val(user_id);
            $('input[name="name"]').val(user.name);
            $('input[name="status"][value="' + user.status + '"]').prop('checked', true);
            $('#adminModal').modal('show');
        });
    });


    /***  Handle Add & Edit Form Submission ***/
    $('#adminForm').submit(function(e) {
        e.preventDefault();
        let user_id = $('input[name="user_id"]').val();
        let url = user_id ? '{{ route('grade.update', ':id') }}'.replace(':id', user_id) :
            "{{ route('grade.store') }}";
        let method = user_id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add this line
            },
            data: $(this).serialize() + "&_method=" + method,
            success: function(response) {
                $('#adminModal').modal('hide');
                grade_table.ajax.reload();
                show_success(response.message);
            },
            error: function(response) {
                display_errors(response.responseJSON.errors);
                // show_error('Error occurred!');
            }
        });
    });


    /***** conformation *****/
    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this grade? Once deleted, it cannot be recovered.",
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

    /*** single grade delete ***/
    $(document).on('click', '.deleteGrade', function(event) {
        event.preventDefault();
        let userId = $(this).data('id');        // Get the user ID
        let form = $('#delete-form-' + userId); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "You want to remove this Grade? Once deleted, it cannot be recovered.",
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


    function display_errors(errors) {
        $("#adminForm .error-text").text('');
        $.each(errors, function(key, value) {
            $('input[name=' + key + ']').addClass('is-invalid');
            $('.' + key + '_error').text(value[0]).addClass('text-danger');
        });
    }


    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.grade_checkbox').prop('checked', this.checked);

    });


    $(document).on('change', '.grade_checkbox', function() {
        let count = $('.grade_checkbox:checked').length; // Count checked checkboxes
        $('#checked-count').text(count); // Display count in an element
        if (count > 0) {
            $('#bulk_delete_button').show();
        } else {
            $('#bulk_delete_button').hide();
        }
    });


    // Handle Bulk Delete button click
    $('#bulk_delete_button').click(function() {
        confirmDeletion(function() {
            var selectedIds = $('.grade_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('grade.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        grade_table.ajax.reload();
                        // location.reload();
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
    });
</script>
@endsection
