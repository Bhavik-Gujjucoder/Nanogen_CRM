@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="card flex-fill">
            <div class="card-body">
                <form method="POST" action="{{ route('distributors_dealers.report', ['id' => $dd_id]) }}"
                    class="row align-items-end g-3 mb-4" id="reportFilterForm">
                    @csrf
                    <div class="col-md-3">
                        <div class="mb-0">
                            <label class="col-form-label">Start Date</label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="start_date"
                                    value="{{ old('start_date', request()->start_date) }}" id="startDate"
                                    class="form-control" placeholder="DD/MM/YY" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-0">
                            <label class="col-form-label">End Date</label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="end_date" value="{{ old('end_date', request()->end_date) }}"
                                    id="endDate" class="form-control" placeholder="DD/MM/YY" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="individual-product">
                            <label class="col-form-label"> Products </label>
                            <select name="product_id" class="form-control select search-dropdown" id="productId">
                                <option value="">Select</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id', request()->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('distributors_dealers.report', ['id' => $dd_id]) }}"
                            class="btn btn-light w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="col-xxl-12 d-flex"> <!-- -->
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Total Number of Order</h5>
                </div>
                <div class="card-body pb-0">
                    <div id="company-chart"></div>
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mb-1">
                            <h5 class="mb-1">{{ $total_order }}</h5>
                        </div>
                        <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Product Billing Amount</h5>
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mb-1">
                            <h5 class="mb-1">{{ IndianNumberFormat($grand_total) }}</h5>
                        </div>
                        <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i
                                class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Product Billing Amount</p>
                    </div>
                    <div id="revenue-income"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Recent Orders -->
<div class="row">
    <div class="col-xxl-12 col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2"><i class="ti ti-grip-vertical me-1"></i>All Orders</h5>
            </div>
            <div class="card-body pb-2">
                <table class="table dataTable no-footer" id="order_management">
                    <thead class="thead-light">
                        <tr>
                            <th hidden>ID</th>
                            <th scope="col">Sr no</th>
                            <th scope="col"><strong>Order ID</strong></th>
                            <th scope="col"><strong>Firm Name</strong></th>
                            <th scope="col"><strong>City</strong></th>
                            <th scope="col"><strong>Order Date</strong></th>
                            <th scope="col"><strong>Contact Number</strong></th>
                            <th scope="col"><strong>Salesman</strong></th>
                            <th scope="col"><strong>Total</strong></th>
                            <th scope="col"><strong>Discount</strong></th>
                            <th scope="col"><strong>Order Status</strong></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Recent Orders -->
<div class="row">
    <div class="col-xxl-12 col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2"><i class="ti ti-grip-vertical me-1"></i>All Products</h5>
            </div>
            <div class="card-body pb-2">
                <table class="table dataTable no-footer" id="product_management">
                    <thead class="thead-light">
                        <tr>
                            <th hidden>ID</th>
                            <th scope="col">Sr no</th>
                            <th scope="col"><strong>Product Name</strong></th>
                            <th scope="col"><strong>Order ID</strong></th>
                            <th scope="col"><strong>Product Price</strong></th>
                            <th scope="col"><strong>Product Quantity</strong></th>
                            <th scope="col"><strong>Billing price</strong></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var dd_id = '{{ $dd_id }}';
    var all_order_show = $('#order_management').DataTable({
        "pageLength": 10,
        deferRender: true,
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: '{{ route('distributors_dealers.report', ':id') }}'.replace(':id', dd_id),
            data: function(d) {
                d.table = 'orders';
                d.dd_id = '{{ $dd_id }}';
                d.product_id = "{{ request('product_id') }}";
                d.start_date = "{{ request('start_date') }}";
                d.end_date = "{{ request('end_date') }}";
            }
        },
        columns: [{
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
                data: 'unique_order_id',
                name: 'unique_order_id',
                searchable: true
            },
            {
                data: 'dd_id',
                name: 'dd_id',
                searchable: true,
                orderable: true,
            },
            {
                data: 'city',
                name: 'city',
                searchable: true,
                orderable: false,
            },
            {
                data: 'order_date',
                name: 'order_date',
                searchable: true,
                orderable: true
            },
            {
                data: 'mobile_no',
                name: 'mobile_no',
                searchable: true,
                orderable: true
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true,
                orderable: true
            },
            {
                data: 'grand_total',
                name: 'grand_total',
                searchable: true,
                orderable: true
            },
            {
                data: 'payment_discount',
                name: 'payment_discount',
                searchable: true,
                orderable: true
            },
            {
                data: 'order_status',
                name: 'order_status',
                searchable: true,
                orderable: true
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // },
        ],
        // columnDefs: [{
        //         targets: 0, // Checkbox
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Select');
        //         }
        //     },
        //     {
        //         targets: 1, // ID (hidden) — skip or still apply if needed
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'ID');
        //         }
        //     },
        //     {
        //         targets: 2, // SR. Number
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Sr no');
        //         }
        //     },
        //     {
        //         targets: 3, // Order ID
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Order ID');
        //         }
        //     },
        //     {
        //         targets: 4, // Party Name
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Party Name');
        //         }
        //     },
        //     {
        //         targets: 5, // City
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'City');
        //         }
        //     },
        //     {
        //         targets: 6, // Order Date
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Order Date');
        //         }
        //     },
        //     {
        //         targets: 7, // Contact Number
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Contact Number');
        //         }
        //     },
        //     {
        //         targets: 8, // Salesman
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Salesman');
        //         }
        //     },
        //     {
        //         targets: 9, // Total
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Total');
        //         }
        //     },
        //     {
        //         targets: 10, // Order Status
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Order Status');
        //         }
        //     },
        //     {
        //         targets: 11, // Action
        //         createdCell: function(td) {
        //             $(td).attr('data-label', 'Action');
        //         }
        //     }
        // ]

    });

    var all_product_show = $('#product_management').DataTable({
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
            url: '{{ route('distributors_dealers.report', ':id') }}'.replace(':id', dd_id),
            data: function(d) {
                d.table = 'products';
                d.dd_id = '{{ $dd_id }}';
                d.product_id = "{{ request('product_id') }}";
                d.start_date = "{{ request('start_date') }}";
                d.end_date = "{{ request('end_date') }}";
            }
        },
        columns: [{
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
                data: 'product_id',
                name: 'product_id',
                searchable: true
            },
            {
                data: 'order_id',
                name: 'order_id',
                searchable: true
            },
            {
                data: 'price',
                name: 'price',
                searchable: true,
                orderable: true,
            },
            {
                data: 'qty',
                name: 'qty',
                searchable: true,
                orderable: true,
            },
            {
                data: 'total',
                name: 'total',
                searchable: true,
                orderable: false,
            },
        ],
    });

    // $('#reportFilterForm').on('submit', function(e) {
    //     e.preventDefault();

    //     all_order_show.ajax.reload();
    //     all_product_show.ajax.reload();
    //     // location.reload();

    // });

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
            maxDate: "today",
            defaultDate: "{{ old('start_date', request()->start_date) }}",
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
            maxDate: "today",
            defaultDate: "{{ old('end_date', request()->end_date) }}",
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


    /*** Order Status update ***/
    $(document).on('click', '.change-status', function() {
        let order_id = $(this).data('id');
        let status = $(this).data('status');

        let url = order_id ? '{{ route('order_management.order_status', ':id') }}'.replace(':id', order_id) :
            "";

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                status: status
            },
            success: function(res) {
                if (res.success == true) {
                    $('#order_management').DataTable().ajax.reload(null, false);
                    show_success('Order status updated successfully!');
                } else {
                    show_error(res.error);
                }
            },
            // error: function(response) {
            //     show_error(response.error);
            // }
        });
    });
    /*** End ***/

    /*** select option search functionality ***/
    $(document).ready(function() {
        $('.search-dropdown').select2({
            placeholder: "Select",
        });
    });
</script>
@endsection
