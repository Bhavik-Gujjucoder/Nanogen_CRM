@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<!-- /Page Header -->
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

                    <a href="{{ route('variation.create') }}" class="btn btn-primary">
                        <i class="ti ti-square-rounded-plus me-2"></i>Add Pricing and Product Variation</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">
        <div class="table-responsive custom-table">
            <table class="table" id="variation_table">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="variation_checkbox"><span class="checkmarks"></span>
                            </label>
                        </th>
                        {{-- <th scope="col">SR. Number</th> --}}
                        <th class="no-sort" scope="col"></th>
                        <th scope="col">Variation Name</th>
                        <th scope="col">Options</th>
                        <th scope="col">Status</th>
                        <th class="no-sort" scope="col">Action</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>
</div>

@endsection
@section('script')
<script>
    /***** DataTable *****/
    var variation_table_show = $('#variation_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('variation.index') }}",
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
                data: 'name',
                name: 'name',
                searchable: true
            },
            {
                data: 'value',
                name: 'value',
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
        variation_table_show.search(this.value).draw();
    });

    /***** conformation *****/
    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this variation? Once deleted, it cannot be recovered.",
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

    /***** conformation Delete-MSG *****/
    $(document).on('click', '.deleteVariation', function(event) {
        event.preventDefault();
        let variationId = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + variationId); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });

    });


    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.variation_checkbox').prop('checked', this.checked);

    });

    $(document).on('change', '.variation_checkbox', function () {
        let count = $('.variation_checkbox:checked').length; // Count checked checkboxes
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
            var selectedIds = $('.variation_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('variation.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        variation_table_show.ajax.reload();
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
        // Get the IDs of selected checkboxes
    });
</script>
@endsection
