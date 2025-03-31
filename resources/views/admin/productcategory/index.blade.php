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
                    <input type="text" class="form-control" id="customSearch" placeholder="Search User">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">

                    <a href="javascript:void(0)" id="openModal" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add Product Category</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- Manage Users List -->
        <div class="table-responsive custom-table">
            <table class="table" id="category_table">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>

                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="category_checkbox"><span
                                    class="checkmarks"></span>
                            </label>
                        </th>
                        <th class="no-sort" scope="col">Id</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Parent Category Name</th>
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
                <h5 class="modal-title" id="modalTitle">Add Product Category</h5>
                <button type="button" class="btn-close close_poup" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm">
                    @csrf
                    <input type="hidden" name="category_id">

                    <div class="mb-3">
                        <label class="col-form-label">Select Parent Category</label>
                        <select class="select" name="parent_category_id" style="height: 210px;" ">
                            <option value="0">{{ __('Select Parent Category') }}</option>
                              @foreach ($category as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">Category name</label>
                        <input type="text" name="category_name" value="" class="form-control"
                            placeholder="Enter category name">
                        <span class="category_name_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        <button type="button" class="btn btn-light me-2 close_poup"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var category_table_show = $('#category_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('product_category.index') }}",
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            }, {
                data: 'id',
                name: 'id',
                searchable: true
            }, {
                data: 'category_name',
                name: 'category_name',
                searchable: true
            },
            {
                data: 'parent_category_id',
                name: 'parent_category_id',
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
        category_table_show.search(this.value).draw();
    });

    /***** Open Modal for Add a New product category *****/
    $('#openModal').click(function() {
        $('#categoryForm')[0].reset();
        $('#adminModal').modal('show');
        $('#modalTitle').text('Add Product Category');
        $('#submitBtn').text('Create');
        $('input[name="category_id"]').val('');
        $('select[name="parent_category_id"]').parent().show();
        $("#categoryForm .text-danger").text('');
        $('#categoryForm').find('.is-invalid').removeClass('is-invalid');

    });

    /***** Open Modal for Editing an Admin *****/
    $(document).on('click', '.edit-btn', function() {
        let category_id = $(this).data('id');
        // alert(category_id);
        $("#categoryForm .text-danger").text('');
        $('#categoryForm').find('.is-invalid').removeClass('is-invalid');

        $.get('{{ route('product_category.edit', ':id') }}'.replace(':id', category_id), function(category) {
            console.log(category);
            $('#modalTitle').text('Edit Product Category');
            $('#submitBtn').text('Update');
            $('input[name="category_id"]').val(category_id);
            if (category.parent_category_id) {
                $('select[name="parent_category_id"]').val(category.parent_category_id).trigger(
                    'change');
            } else {
                $('select[name="parent_category_id"]').parent().hide();
            }
            $('input[name="category_name"]').val(category.category_name);
            $('input[name="status"][value="' + category.status + '"]').prop('checked', true);
            $('#adminModal').modal('show');
        });
    });

    /***** Add & Edit Form Submission *****/
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        let category_id = $('input[name="category_id"]').val();
        let url = category_id ? '{{ route('product_category.update', ':id') }}'.replace(':id', category_id) :
            "{{ route('product_category.store') }}";
        let method = category_id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize() + "&_method=" + method,
            success: function(response) {
                $('#adminModal').modal('hide');
                category_table_show.ajax.reload();
                location.reload();
                show_success(response.message);
            },
            error: function(response) {
                display_errors(response.responseJSON.errors);
            }
        });
    });

    /***** Delete *****/
    $(document).on('click', '.deleteCategory', function(event) {
        event.preventDefault();
        let categoryId = $(this).data('id');
        let form = $('#delete-form-' + categoryId); // Select the correct form
        console.log(form);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this category? Once deleted, it cannot be recovered.",
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

    function display_errors(errors) {
        $("#categoryForm .error-text").text('');
        $.each(errors, function(key, value) {
            $('input[name=' + key + ']').addClass('is-invalid');
            console.log($('input[name=' + key + ']'));
            $('.' + key + '_error').text(value[0]).addClass('text-danger');
        });
    }

    // $(".dataTables_filter").hide();
    // $(".dataTables_length").hide();


    /***** Bulk Delete *****/
    $(document).ready(function() {
        $('.category_checkbox').change(function() {

            // Handle checkbox change event to show/hide the bulk delete button
            $('#select-all').change(function() {
                // Check/uncheck all checkboxes when the select-all checkbox is clicked
                $('.category_checkbox').prop('checked', this.checked);
                toggleBulkDeleteButton();
            });

            // Handle individual checkbox change event
            $('.category_checkbox').change(function() {
                toggleBulkDeleteButton();
            });

            function toggleBulkDeleteButton() {
                var selectedCheckboxes = $('.category_checkbox:checked').length;

                if (selectedCheckboxes > 0) {
                    $('#bulk_delete_button').show(); // Show delete button
                } else {
                    $('#bulk_delete_button').hide(); // Hide delete button
                }
            }
        });

        // Handle Bulk Delete button click
        $('#bulk_delete_button').click(function() {
            // Get the IDs of selected checkboxes
            var selectedIds = $('.category_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: '/bulk-delete', // The route where the delete request will be sent
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        alert(response.message); // Show a success message
                        // Optionally, reload the page to reflect changes
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred while deleting.");
                    }
                });
            } else {
                alert("No items selected.");
            }
        });
    });
</script>
@endsection
