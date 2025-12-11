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
                            class="ti ti-square-rounded-plus me-2"></i>Add Position</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- Manage Users List -->
        <div class="table-responsive custom-table">
            <table class="table" id="position_table">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="sales_position_checkbox">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th class="no-sort" scope="col">Sr no</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!--  Single Modal for Add & Edit -->
<div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Position</h5>
                {{-- <button type="button" class="btn-close close_poup" data-bs-dismiss="modal"></button> --}}
                <button class="btn-close custom-btn-close border p-1 me-0 text-dark" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ti ti-x"></i>
            </div>
            <div class="modal-body">
                <form id="salesPositionForm">
                    @csrf
                    <input type="hidden" name="sales_position_id">
                    <div class="mb-3">
                        <label class="col-form-label">Name *</span></label>
                        <input type="text" name="name" value="" class="form-control"
                            placeholder="Enter name" maxlength="250">
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
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var position_table_show = $('#position_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: {
            url: '{{ route('sales_position.index') }}',
            data: function(d) {
                d.show_parent = false; // Unique identifier for this table
            },
        },

        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            }, {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
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
        columnDefs: [{
                targets: 0, // ID (hidden)
                createdCell: function(td) {
                    $(td).attr('data-label', 'ID');
                }
            },
            {
                targets: 1, // Checkbox
                createdCell: function(td) {
                    $(td).attr('data-label', 'Select');
                }
            },
            {
                targets: 2, // Sr no
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sr. No.');
                }
            },
            {
                targets: 3, //  Name
                createdCell: function(td) {
                    $(td).attr('data-label', 'Category Name');
                }
            },
            {
                targets: 4, // Status
                createdCell: function(td) {
                    $(td).attr('data-label', 'Status');
                }
            },
            {
                targets: 5, // Action
                createdCell: function(td) {
                    $(td).attr('data-label', 'Action');
                }
            }
        ]
    });

    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        position_table_show.search(this.value).draw();
    });


    // $(document).ready(function() {
    //     $('.parent_category_id').select2({
    //         dropdownParent: $('#adminModal'),
    //     });
    // });

    /***** Open Modal for Add a New product category *****/
    $('#openModal').click(function() {
        $('#salesPositionForm')[0].reset();
        $('#adminModal').modal('show');
        $('#modalTitle').text('Add Position');
        $('#submitBtn').text('Create');
        $('input[name="category_id"]').val('');
        // $('select[name="parent_category_id"]').parent().show();
        $("#salesPositionForm .text-danger").text('');
        $('#salesPositionForm').find('.is-invalid').removeClass('is-invalid');
    });


    /***** Open Modal for Editing an Admin *****/
    $(document).on('click', '.edit-btn', function() {
        let sales_position_id = $(this).data('id');
        // alert(category_id);
        $("#salesPositionForm .text-danger").text('');
        $('#salesPositionForm').find('.is-invalid').removeClass('is-invalid');

        $.get('{{ route('sales_position.edit', ':id') }}'.replace(':id', sales_position_id), function(sales_position) {
            console.log(sales_position);
            $('#modalTitle').text('Edit Position');
            $('#submitBtn').text('Update');
            $('input[name="sales_position_id"]').val(sales_position_id);

            $('input[name="name"]').val(sales_position.name);
            $('input[name="status"][value="' + sales_position.status + '"]').prop('checked', true);
            $('#adminModal').modal('show');
        });
    });

    /***** Add & Edit Form Submission *****/
    $('#salesPositionForm').submit(function(e) {
        e.preventDefault();
        let sales_position_id = $('input[name="sales_position_id"]').val();
        let url = sales_position_id ? '{{ route('sales_position.update', ':id') }}'.replace(':id', sales_position_id) :
            "{{ route('sales_position.store') }}";
        let method = sales_position_id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize() + "&_method=" + method,
            success: function(response) {
                $('#adminModal').modal('hide');
                position_table_show.ajax.reload();
                show_success(response.message);
                // location.reload();
            },
            error: function(response) {
                display_errors(response.responseJSON.errors);
            }
        });
    });


    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this Position? Once deleted, it cannot be recovered.",
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
                callback(); /* Execute callback function if confirmed */
            }
        });
    }

    /***** Delete *****/
    $(document).on('click', '.deleteSalesPosition', function(event) {
        event.preventDefault();
        let categoryId = $(this).data('id');
        let form = $('#delete-sales-position-form-' + categoryId); // Select the correct form

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
       
    });

    function display_errors(errors) {
        $("#salesPositionForm .error-text").text('');
        $.each(errors, function(key, value) {

            /** Handle input fields validation using controller validated ***/
            $('input[name=' + key + ']').addClass('is-invalid');
            console.log($('input[name=' + key + ']'));
            $('.' + key + '_error').text(value[0]).addClass('text-danger');

            /** handle option dropdown validation using controller validated **/
            $('select[name=' + key + ']').addClass('is-invalid');
            $('.' + key + '_error').text(value[0]).addClass('text-danger');
        });
    }


    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        /* Check/uncheck all checkboxes when the select-all checkbox is clicked */
        $('.sales_position_checkbox').prop('checked', this.checked);

    });

    $(document).on('change', '.sales_position_checkbox', function() {
        let count = $('.sales_position_checkbox:checked').length; // Count checked checkboxes
        $('#checked-count').text(count); // Display count in an element
        if (count > 0) {
            $('#bulk_delete_button').show();
        } else {
            $('#bulk_delete_button').hide();
        }
    });

    /* Handle Bulk Delete button click */
    $('#bulk_delete_button').click(function() {
        confirmDeletion(function() {
            var selectedIds = $('.sales_position_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                /* Make an AJAX request to delete the selected items */
                $.ajax({
                    url: "{{ route('sales_position.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        position_table_show.ajax.reload();
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
</script>
@endsection
