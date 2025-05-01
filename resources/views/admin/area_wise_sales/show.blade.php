@extends('layouts.main')
@section('content')
@section('title')
@endsection
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-2">{{ $page_title }}</h4>
            <h5>{{ __('Region Name : ') }} {{ $city_name }}</h5>
        </div>
        <div class="areawise col-md-4 d-flex">
            <div class="main-catgeory">
                <h6> Main ategory </h6>
                <select name="category_id" class="form-control select" onchange="applyFilter()">
                    <option value="">Select</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="individual-product">
                <h6> Individual Product </h6>
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
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap table-hover mb-0" id="area_wise_show">
                <thead>
                    <tr>
                        <th scope="col">#</th>
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

    });

    function applyFilter() {
        area_wise_show.ajax.reload();
    }
    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        area_wise.search(this.value).draw();
    });
</script>
@endsection
