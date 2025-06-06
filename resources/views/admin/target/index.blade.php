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
                    {{-- <div class="dropdown me-2">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-package-export me-2"></i>Export</a>
                        <div class="dropdown-menu  dropdown-menu-end">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="ti ti-file-type-pdf text-danger me-1"></i>Export as PDF
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="ti ti-file-type-xls text-green me-1"></i>Export as Excel
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                    <a href="{{ route('target.create') }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add New Target</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- Projects List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="target_table">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="target_checkbox">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">Sr no</th>
                        <th scope="col">Target Name</th>
                        <th scope="col">Sales Person Name</th>
                        <th scope="col">Traget Value</th>
                        <th scope="col">Region</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        {{-- <th scope="col">Target Result</th> --}}
                        <th class="{{-- text-end --}}" scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- /Projects List -->
    </div>
</div>

@endsection
@section('script')
<script>
    /***** DataTable *****/
    var target_show = $('#target_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [1, 'desc']
        ],
        ajax: "{{ route('target.index') }}",
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
                data: 'subject',
                name: 'subject',
                searchable: true
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true
            },
            {
                data: 'target_value',
                name: 'target_value',
                searchable: true,
                orderable: true
            },
            {
                data: 'city_id',
                name: 'city_id',
                searchable: true,
                orderable: true
            },
            {
                data: 'start_date',
                name: 'start_date',
                searchable: true
            },
            {
                data: 'end_date',
                name: 'end_date',
                searchable: true
            },
            // { data: 'target_result', name: 'target_result' },
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
                targets: 1, // ID (hidden)
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
                targets: 3, // Target Name
                createdCell: function(td) {
                    $(td).attr('data-label', 'Target Name');
                }
            },
            {
                targets: 4, // Sales Person Name
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sales Person Name');
                }
            },
            {
                targets: 5, // Target Value
                createdCell: function(td) {
                    $(td).attr('data-label', 'Target Value');
                }
            },
            {
                targets: 6, // Region
                createdCell: function(td) {
                    $(td).attr('data-label', 'Region');
                }
            },
            {
                targets: 7, // Start Date
                createdCell: function(td) {
                    $(td).attr('data-label', 'Start Date');
                }
            },
            {
                targets: 8, // End Date
                createdCell: function(td) {
                    $(td).attr('data-label', 'End Date');
                }
            },
            {
                targets: 9, // Action
                createdCell: function(td) {
                    $(td).attr('data-label', 'Action');
                }
            }
        ]

    });

    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        target_show.search(this.value).draw();
    });



    /***** Alert Delete-MSG *****/
    $(document).on('click', '.deleteTarget', function(event) {
        event.preventDefault();
        let targetId = $(this).data('id'); // Get the target ID
        let form = $('#delete-form-' + targetId); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this Target? Once deleted, it cannot be recovered.",
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

    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.target_checkbox').prop('checked', this.checked);

    });

    $(document).on('change', '.target_checkbox', function() {
        let count = $('.target_checkbox:checked').length; // Count checked checkboxes
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
            var selectedIds = $('.target_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                // Make an AJAX request to delete the selected items
                $.ajax({
                    url: "{{ route('target.bulkDelete') }}",
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
                        target_show.ajax.reload();

                        $('#bulk_delete_button').hide();
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
