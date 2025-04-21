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
                    <input type="text" class="form-control" id="customSearch" placeholder="Search Orders">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">

                    <a href="{{ route('order_management.create') }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add Order</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">
        <!-- order management List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="order_management">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="order_checkbox"><span
                                    class="checkmarks"></span></label>
                            </label>
                        </th>
                        <th class="no-sort" scope="col"></th>
                        <th scope="col">Party Name</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Salesman</th>
                        <th scope="col">Total</th>
                        <th scope="col">Order Status</th>
                        <th class="text-end" scope="col">Action</th>
                    </tr>
                </thead>
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

    </div>
</div>

@endsection
@section('script')
<script>
    /***** DataTable *****/
    var order_management_show = $('#order_management').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('order_management.index') }}",
        columns: [{
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
            }, // Auto-increment number
            {
                data: 'dd_id',
                name: 'dd_id',
                searchable: true
            },
            {
                data: 'order_date',
                name: 'order_date',
                searchable: true,
                orderable: false
            },
            {
                data: 'mobile_no',
                name: 'mobile_no',
                searchable: true,
                orderable: false
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true
            },
            {
                data: 'grand_total',
                name: 'grand_total',
                searchable: true
            },
            {
                data: 'order_status',
                name: 'order_status',
                searchable: true,
                orderable: true
            },
           
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
    });

    /*** Order Status update ***/
    $(document).on('click', '.change-status', function() {
        let order_id = $(this).data('id');
        let status = $(this).data('status');

        let url = order_id ? '{{ route('order_management.order_status', ':id') }}'.replace(':id', order_id) : "";

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                status: status
            },
            success: function(res) {
                $('#order_management').DataTable().ajax.reload(null, false);
                show_success('Status updated successfully!');
            }
        });
    });
    /*** End ***/

    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        order_management_show.search(this.value).draw();
    });


    /***** Alert Delete-MSG *****/
    $(document).on('click', '.deleteOrder', function(event) {
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
        $('.order_checkbox').prop('checked', this.checked);

    });

    $(document).on('change', '.order_checkbox', function() {
        let count = $('.order_checkbox:checked').length; // Count checked checkboxes
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
            var selectedIds = $('.order_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('order_management.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        /** Send the selected IDs **/
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        order_management_show.ajax.reload();
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

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this order? Once deleted, it cannot be recovered.",
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
