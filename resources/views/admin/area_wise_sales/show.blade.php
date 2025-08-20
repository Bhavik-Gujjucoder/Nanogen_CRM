@extends('layouts.main')
@section('content')
@section('title')
@endsection
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-4">
            <h4 class="page-title mb-2">{{ $page_title }}</h4>
            <h5>{{ __('Region Name : ') }} {{ $city_name }}</h5>
            <strong>{{ __('Total Sales Amount : ') }} {{ IndianNumberFormat($city_wise_total_sales) }}</strong>
        </div>
        <div class="areawise col-md-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="col-form-label">Start Date <span class="text-danger">*</span></label>
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" name="start_date" value="{{ old('start_date') }}" id="startDate"
                                class="form-control" placeholder="DD/MM/YY" onchange="applyFilter()">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="col-form-label">End Date <span class="text-danger">*</span></label>
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" name="end_date" value="{{ old('end_date') }}" id="endDate"
                                class="form-control" placeholder="DD/MM/YY" onchange="applyFilter()">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="main-catgeory">
                        <label class="col-form-label"> Main Category </label>
                        <select name="category_id" class="form-control select" onchange="applyFilter()">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="individual-product">
                        <label class="col-form-label"> Individual Product </label>
                        <select name="product_id" class="form-control select" onchange="applyFilter()">
                            <option value="">Select</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap table-hover mb-0" id="area_wise_show">
                <thead>
                    <tr>
                        <th scope="col">Sr no</th>
                        <th scope="col">Order No</th>
                        <th scope="col">Distributor Name</th>
                        <th scope="col">Sales Person</th>
                        <th scope="col">Product & Quantity</th>
                        <th scope="col">Date</th>
                        <th scope="col">Sales Amount</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Order Popup Modal Structure -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="popupModalContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var area_wise_show = $('#area_wise_show').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('area_wise_sales.show', $city_id) }}",
            data: function(d) {
                d.product_id = $('select[name="product_id"]')
                    .val(); // Pass selected group IDs as a parameter
                d.category_id = $('select[name="category_id"]')
                    .val(); // Pass selected group IDs as a parameter

                d.start_date = $('#startDate').val(); // Pass start date
                d.end_date = $('#endDate').val(); // Pass end date
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'unique_order_id',
                name: 'unique_order_id',
                searchable: true
            },
            {
                data: 'dd_id',
                name: 'dd_id',
                searchable: true
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true
            },
            {
                data: 'product_qty',
                name: 'product_qty',
                searchable: true,
                orderable: true,
            },
            {
                data: 'order_date',
                name: 'order_date',
                searchable: true,
                orderable: true
            },
            {
                data: 'grand_total',
                name: 'grand_total',
                searchable: true,
                orderable: true,
            },
            {
                data: 'status',
                name: 'status',
                searchable: true,
                orderable: true,
            },
        ],
        columnDefs: [{
                targets: 0, // Sr no
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sr no');
                }
            },
            {
                targets: 1, // Order No
                createdCell: function(td) {
                    $(td).attr('data-label', 'Order No');
                }
            },
            {
                targets: 2, // Distributor Name
                createdCell: function(td) {
                    $(td).attr('data-label', 'Distributor Name');
                }
            },
            {
                targets: 3, // Sales Person
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sales Person');
                }
            },
            {
                targets: 4, // Product & Quantity
                createdCell: function(td) {
                    $(td).attr('data-label', 'Product & Quantity');
                }
            },
            {
                targets: 5, // Date
                createdCell: function(td) {
                    $(td).attr('data-label', 'Date');
                }
            },
            {
                targets: 6, // Sales Amount
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sales Amount');
                }
            },
            {
                targets: 7, // Status
                createdCell: function(td) {
                    $(td).attr('data-label', 'Status');
                }
            }
        ]

    });

    function applyFilter() {
        area_wise_show.ajax.reload();
    }
    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        area_wise.search(this.value).draw();
    });



    /*** Order Popup Model ***/
    $(document).on('click', '.open-popup-model', function(e) {
        e.preventDefault();
        // var url = $(this).attr('href'); // URL of the order detail route

        let order_id = $(this).data('id'); // Data ID passed from the anchor tag
        let url = order_id ? '{{ route('area_wise_sales.order_show', ':id') }}'.replace(':id', order_id) : "";

        // Show SweetAlert2 loading spinner while fetching the data
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we load the order details.',
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
                        title: 'Order Details',
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
                Swal.fire('Error', 'Could not load order details.', 'error');
            }
        });



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
</script>
@endsection
