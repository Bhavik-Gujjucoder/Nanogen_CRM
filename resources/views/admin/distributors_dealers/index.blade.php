@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-header">
        <!-- Search -->
        <div class="row align-items-center sale-sec">
            <div class="col-sm-12 col-lg-2 col-md-12 mb-3">
                <div class="icon-form mb-4 mb-sm-0 mt-4">

                    <span class="form-icon"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" id="customSearch" placeholder="Search">
                </div>
            </div>

            @if (!auth()->user()->hasRole('sales'))
                <div class="col-sm-12 col-lg-2 col-md-12">
                    <div class="mb-3">
                        <label class="col-form-label">Sales Person </label>
                        <select class="form-select select search-dropdown" name="sales_person_id" id="sales_person_id">
                            <option value="">Select sales person</option>
                            @foreach ($sales_persons as $s)
                                <option value="{{ $s->user_id }}"
                                    {{ old('sales_person_id') == $s->user_id ? 'selected' : '' }}>
                                    {{ $s->first_name . ' ' . $s->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <span id="sales_person_id_error" class="text-danger"></span>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-2 col-md-12">
                    <div class="mb-3">
                        <label class="col-form-label">Start Date</label>
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" name="start_date" value="{{ old('start_date') }}" id="startDate"
                                class="form-control" placeholder="DD/MM/YY" onchange="applyFilter()">
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-2 col-md-12">
                    <div class="mb-3">
                        <label class="col-form-label">End Date</label>
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" name="end_date" value="{{ old('end_date') }}" id="endDate"
                                class="form-control" placeholder="DD/MM/YY" onchange="applyFilter()">
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-sm-12 col-lg-4 col-md-12">
                <div class="d-flex align-items-center flex-wrap row-gap-2 column-gap-1 justify-content-sm-end btn-cls">

                    <div class="dropdown me-2 gc-export-menu">
                        <!-- <a href="javascript:void(0);" class="dropdown-toggle"
                      data-bs-toggle="dropdown"><i
                      class="ti ti-package-export me-2"></i>Export</a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="list-unstyled mb-0">
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
                    </div>
                    @if (!auth()->user()->hasRole('sales'))
                        <button type="button" id="exportExcel" class="btn btn-primary">
                            <i class="ti ti-file-type-xls text-success me-1"></i>
                            {{ request('dealer') == 1 ? 'Export Dealers' : 'Export Distributors' }}
                            {{-- Export Excel --}}
                        </button>
                        <a href="{{ route('distributors_dealers.export_price_list_new', request('dealer')) }}"
                            class="btn btn-primary">
                            <i class="ti ti-file-type-xls me-2"></i>
                            Export Price List
                        </a>
                        <a href="{{ route('distributors_dealers.create', request('dealer')) }}"
                            class="btn btn-primary"><i class="ti ti-square-rounded-plus me-2"></i>
                            {{ request('dealer') == 1 ? 'Add Dealers' : 'Add Distributors' }}</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- dealers Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="distributerTable">
                <thead class="thead-light">
                    <tr>
                        {{-- <th class="no-sort" scope="col">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all"><span class="checkmarks"></span>
                            </label>
                        </th> --}}
                        <th hidden>ID</th>
                        <th class="no-sort" scope="col">Sr no</th>
                        <th scope="col">Firm Name</th>
                        <th scope="col"> {{ request('dealer') == 1 ? 'Dealer Name' : 'Distributor Name' }}</th>
                        <th scope="col">Sales Person</th>
                        <th scope="col">Phone</th>
                        <th scope="col">City</th>
                        <th scope="col">Code</th>
                        <th scope="col">Date</th>
                        @if (!auth()->user()->hasRole('sales'))
                            <th class="" scope="col">Action</th> {{-- class="text-end" --}}
                        @endif
                    </tr>
                </thead>
            </table>
        </div>

        <!-- /dealers Users List -->
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.search-dropdown').select2({
            placeholder: "Select",
            // allowClear: true
        });
    });
    $('#sales_person_id').on('change', function() {
        distributors_dealers_table.draw();
    });
    $('#startDate').on('change', function() {
        distributors_dealers_table.draw();
    });
    $('#endDate').on('change', function() {
        distributors_dealers_table.draw();
    });

    const isSales = @json(auth()->user()->hasRole('sales'));
    var distributors_dealers_table = $('#distributerTable').DataTable({

        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [0, 'desc']
        ],
        // ajax: "{{ route('distributors_dealers.index', request('dealer')) }}",
        ajax: {
            url: "{{ route('distributors_dealers.index', request('dealer')) }}",
            data: function(d) {
                d.sales_person_id = $('#sales_person_id').val();
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            // { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'firm_shop_name',
                name: 'firm_shop_name',
                searchable: true
            },
            {
                data: 'applicant_name',
                name: 'applicant_name',
                searchable: true
            },
            {
                data: 'sales_person_id',
                name: 'sales_person_id',
                searchable: true
            },
            {
                data: 'mobile_no',
                name: 'mobile_no',
                searchable: true
            },
            {
                data: 'city_id',
                name: 'city_id',
                searchable: true
            },
            {
                data: 'code_no',
                name: 'code_no',
                searchable: true
            },
            {
                data: 'created_at',
                name: 'created_at',
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                visible: !isSales // hides for sales
            },
        ],
        columnDefs: [{
                targets: 0, // ID (hidden)
                createdCell: function(td) {
                    $(td).attr('data-label', 'ID');
                }
            },
            {
                targets: 1, // Sr no
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sr. No.');
                }
            },
            {
                targets: 2, // Dealer/Distributor Name (based on request)
                createdCell: function(td) {
                    const label = '{{ request('dealer') == 1 ? 'Dealer Name' : 'Distributor Name' }}';
                    $(td).attr('data-label', label);
                }
            },
            {
                targets: 3, // Phone
                createdCell: function(td) {
                    $(td).attr('data-label', 'Phone');
                }
            },
            {
                targets: 4, // City
                createdCell: function(td) {
                    $(td).attr('data-label', 'City');
                }
            },
            {
                targets: 5, // Code
                createdCell: function(td) {
                    $(td).attr('data-label', 'Code');
                }
            },
            {
                targets: 6, // Date
                createdCell: function(td) {
                    $(td).attr('data-label', 'Date');
                }
            },
            {
                targets: 7, // Action
                createdCell: function(td) {
                    $(td).attr('data-label', 'Action');
                }
            }
        ],
    });

    /*** Custom Search Box ***/
    $('#customSearch').on('keyup', function() {
        distributors_dealers_table.search(this.value).draw();
    });

    $(document).on('click', '.delete_d_d', function(event) {
        event.preventDefault();
        let d_d_Id = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + d_d_Id); // Select the correct form
        console.log(form);

        confirmDeletion(function() {
            form.submit(); // Submit the form if confirmed
        });
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this record? Once deleted, it cannot be recovered.",
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

    /*** Export Excel ****/
    $('#exportExcel').on('click', function() {
        var sales_person_id = $('#sales_person_id').val();
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();

        /* window.location = "{{ route('distributors_dealers.export') }}?sales_person_id=" + sales_person_id; */
        var url = "{{ route('distributors_dealers.export', request('dealer')) }}?sales_person_id=" +
            sales_person_id +
            "&start_date=" + start_date +
            "&end_date=" + end_date;

        window.location = url;

    });

    /*** datepicker ***/
    $(document).ready(function() {
        const startPicker = flatpickr("#startDate", {
            dateFormat: "d-m-Y",
            disableMobile: true,
            // maxDate: "today",
            // defaultDate: "{{ old('start_date', isset($detail) ? \Carbon\Carbon::parse($detail->start_date)->format('d-m-Y') : now()->format('d-m-Y')) }}",
            onChange: function(selectedDates, dateStr, instance) {
                // Set selected start date as minDate for end date
                endPicker.set('minDate', dateStr);
                removeTodayHighlight(selectedDates, dateStr, instance);
            },
            onReady: removeTodayHighlight,
            onMonthChange: removeTodayHighlight,
            onYearChange: removeTodayHighlight,
            onOpen: removeTodayHighlight
        });

        const endPicker = flatpickr("#endDate", {
            dateFormat: "d-m-Y",
            disableMobile: true,
            // maxDate: "today",
            // defaultDate: "{{ old('end_date', isset($detail) ? \Carbon\Carbon::parse($detail->end_date)->format('d-m-Y') : now()->format('d-m-Y')) }}",
            onReady: removeTodayHighlight,
            onMonthChange: removeTodayHighlight,
            onYearChange: removeTodayHighlight,
            onOpen: removeTodayHighlight
        });

        function removeTodayHighlight(selectedDates, dateStr, instance) {
            const todayElem = instance.calendarContainer.querySelector(".flatpickr-day.today");
            if (todayElem && !todayElem.classList.contains("selected")) {
                todayElem.classList.remove("today");
            }
        }
    });
    /*** END ***/


    /*** distributors_dealers show Popup Model ***/
    $(document).on('click', '.open-popup-model', function(e) {
        e.preventDefault();

        let dd_id = $(this).data('id'); // Data ID passed from the anchor tag
        let url = dd_id ? '{{ route('distributors_dealers.show', ':id') }}'.replace(':id', dd_id) : "";

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
