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
                <div
                    class="d-flex align-items-center flex-wrap row-gap-2 column-gap-1 justify-content-sm-end gc-complain-menu">
                    <div class="dropdown me-2">
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
                    </div>
                    <a href="{{ route('complain.create') }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Complain</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">
        <!-- /Filter -->
        <!-- dealers Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="complain">
                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete Selected</button>
                <thead class="thead-light">
                    <tr>
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all" class="complain_checkbox"><span
                                    class="checkmarks"></span>
                            </label>
                        </th>
                        <th class="no-sort" scope="col">Sr no</th>
                        {{-- <th scope="col">Dealer/Distributor</th> --}}
                        <th scope="col">Firm Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Products </th>
                        <th scope="col">Status </th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>
@endsection
@section('script')
<script>
    var complain_table = $('#complain').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [0, 'desc']
        ],
        ajax: "{{ route('complain.index') }}",
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
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, // Auto-increment number
            {
                data: 'firm_shop_name',
                name: 'dd_id',
                searchable: true
            },

            {
                data: 'date',
                name: 'date',
                searchable: true
            },
            {
                data: 'product',
                name: 'product_id',
                searchable: true
            },
            {
                data: 'status',
                name: 'status',
                searchable: true
            },
            {
                data: 'remark',
                name: 'remark',
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
                targets: 3, // Dealer/Distributor
                createdCell: function(td) {
                    $(td).attr('data-label', 'Dealer/Distributor');
                }
            },
            {
                targets: 4, // Date
                createdCell: function(td) {
                    $(td).attr('data-label', 'Date');
                }
            },
            {
                targets: 5, // Products
                createdCell: function(td) {
                    $(td).attr('data-label', 'Products');
                }
            },
            {
                targets: 6, // Status
                createdCell: function(td) {
                    $(td).attr('data-label', 'Status');
                }
            },
            {
                targets: 7, // Remarks
                createdCell: function(td) {
                    $(td).attr('data-label', 'Remarks');
                }
            },
            {
                targets: 8, // Action
                createdCell: function(td) {
                    $(td).attr('data-label', 'Action');
                }
            }
        ]


    });

    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.complain_checkbox').prop('checked', this.checked);
    });

    // Custom Search Box
    $('#customSearch').on('keyup', function() {
        complain_table.search(this.value).draw();
    });


    $(document).on('click', '.deletecomplain', function(event) {
        event.preventDefault();
        let complainId = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + complainId); // Select the correct form

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this Complain? Once deleted, it cannot be recovered.",
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


    $(document).on('change', '.complain_checkbox', function() {
        let count = $('.complain_checkbox:checked').length; // Count checked checkboxes
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
            var selectedIds = $('.complain_checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length > 0) {
                $.ajax({
                    url: "{{ route('complain.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        show_success(response.message);
                        complain_table.ajax.reload();
                        $('#bulk_delete_button').hide();
                    },
                    error: function(xhr, status, error) {
                        show_error('An error occurred while deleting.');
                    }
                });
            } else {
                alert("No items selected.");
            }
        });
    });


    /*** distributors_dealers show Popup Model ***/
    $(document).on('click', '.open-popup-model', function(e) {
        e.preventDefault();

        let dd_id = $(this).data('id'); // Data ID passed from the anchor tag
        let url = dd_id ? '{{ route('complain.show', ':id') }}'.replace(':id', dd_id) : "";

        // Show SweetAlert2 loading spinner while fetching the data
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we load the details.',
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading(); // Show loading spinner
            }
        });

        // Fetch the order data via AJAX
        $.ajax({
            url: url, // Use the URL from the 'href' attribute
            type: 'GET',
            success: function(response) {
                if (response.html) {
                    Swal.fire({
                        // title: 'Details',
                        html: response.html,
                        showCloseButton: true,
                        showConfirmButton: false,
                        width: '80%',
                        heightAuto: true
                    });
                } else {
                    console.error('No HTML returned:', response);
                    Swal.fire('Error', 'No content received from server.', 'error');
                }
            },
            error: function(xhr) {
                console.error('AJAX error:', xhr.responseText);
                Swal.fire('Error', 'Could not load details.', 'error');
            }
        });
    });
</script>
@endsection
