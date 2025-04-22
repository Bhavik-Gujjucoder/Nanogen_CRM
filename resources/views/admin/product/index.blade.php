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

               

                   <a href="{{ route('product.create') }}" class="btn btn-primary"><i
                   class="ti ti-square-rounded-plus me-2"></i>Add Product</a>
             </div>
          </div>
       </div>
       <!-- /Search -->
    </div>
    <div class="card-body">


       <!-- List -->
       <div class="table-responsive custom-table">
          <table class="table" id="product_table">
            <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
             <thead class="thead-light">
                <tr>
                    <th hidden>ID</th>
                   <th class="no-sort" scope="col">
                        <label class="checkboxs">
                            <input type="checkbox" id="select-all" class="product_checkbox"><span class="checkmarks"></span>
                        </label>
                    </th>
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
          </table>
       </div>

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
        order: [[0, 'desc']],  
        ajax: "{{ route('product.index') }}",
        columns: [
            { data: 'id', name: 'id', visible: false, searchable: false },
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


     /***** Alert Delete-MSG *****/
     $(document).on('click', '.deleteVariation', function(event) {
        event.preventDefault();
        let variationId = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + variationId); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this product? Once deleted, it cannot be recovered.",
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

    /****** Bulk delete ******/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.product_checkbox').prop('checked', this.checked);
    });

    $(document).on('change', '.product_checkbox', function () {
        let count = $('.product_checkbox:checked').length; // Count checked checkboxes
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
            var selectedIds = $('.product_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('product.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        product_table_show.ajax.reload();
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
