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

                    <a href="{{ route('sales_person.create') }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add Sales Person</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">
        <!-- Manage Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="sales_person_table">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col"><label class="checkboxs">
                                <input type="checkbox" id="select-all" class="sales_person_checkbox"><span
                                    class="checkmarks"></span></label>
                        </th>
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">Sr no</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Employee ID</th>
                        {{-- <th scope="col">Reporting Manager</th> --}}

                        <th class="" scope="col">Action</th>
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
    var sales_person_table_show = $('#sales_person_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [1, 'desc']
        ],
        ajax: "{{ route('sales_person.index') }}",
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, // Auto-increment number
            {
                data: 'first_name',
                name: 'first_name',
                searchable: true
            },
            {
                data: 'user.phone_no',
                name: 'user.phone_no',
                searchable: true,
                orderable: true
            },
            {
                data: 'user.email',
                name: 'user.email',
                searchable: true,
                orderable: true
            },
            {
                data: 'employee_id',
                name: 'employee_id',
                searchable: true
            },
            // {
            //     data: 'reporting_manager_id',
            //     name: 'reporting_manager_id',
            //     searchable: true
            // },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        columnDefs: [{
                targets: 0, // Checkbox
                createdCell: function(td) {
                    $(td).attr('data-label', 'Select');
                }
            },
            {
                targets: 1, // ID (hidden) – optional
                createdCell: function(td) {
                    $(td).attr('data-label', 'ID');
                }
            },
            {
                targets: 2, // Sr no
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sr. No.');
                }
            },
            {
                targets: 3, // Name
                createdCell: function(td) {
                    $(td).attr('data-label', 'Name');
                }
            },
            {
                targets: 4, // Phone
                createdCell: function(td) {
                    $(td).attr('data-label', 'Phone');
                }
            },
            {
                targets: 5, // Email
                createdCell: function(td) {
                    $(td).attr('data-label', 'Email');
                }
            },
            {
                targets: 6, // Employee ID
                createdCell: function(td) {
                    $(td).attr('data-label', 'Employee ID');
                }
            },
            // {
            //     targets: 7, // Reporting Manager
            //     createdCell: function(td) {
            //         $(td).attr('data-label', 'Reporting Manager');
            //     }
            // },
            {
                targets: 7, // Action
                createdCell: function(td) {
                    $(td).attr('data-label', 'Action');
                }
            }
        ]

    });

    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        sales_person_table_show.search(this.value).draw();
    });


    /* delete */
    $(document).on('click', '.deleteSalesPerson', function(event) {
        event.preventDefault();
        let userId = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + userId); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
    });

    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.sales_person_checkbox').prop('checked', this.checked);

    });

    $(document).on('change', '.sales_person_checkbox', function() {
        let count = $('.sales_person_checkbox:checked').length; // Count checked checkboxes
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
            var selectedIds = $('.sales_person_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('sales_person.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds, // Send the selected IDs
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Swal.fire("Deleted!", response.message, "success");
                        show_success(response.message);
                        // Optionally, reload the page to reflect changes
                        sales_person_table_show.ajax.reload();
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
            text: "You want to remove this sales person? Once deleted, it cannot be recovered.",
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
