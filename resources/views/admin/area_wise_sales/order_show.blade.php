<!-- Display values instead of input fields -->
<div class="row mb-4 order-form order-form-cls">

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Order ID</label>
        <p class="form-control-plaintext">{{ $order->unique_order_id }}</p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Firm Name</label>
        <p class="form-control-plaintext">{{ $order->distributors_dealers->firm_shop_name ?? '-' }}
            @if ($order->distributors_dealers->user_type)
                {{ $order->distributors_dealers->user_type == 1 ? '(Distributor)' : ($order->distributors_dealers->user_type == 2 ? '(Dealers)' : '') }}
        </p>
    @else
        {{ '-' }}
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Order Date</label>
        <p class="form-control-plaintext">{{ $order->order_date->format('d M Y') ?? '-' }}</p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Phone</label>
        <p class="form-control-plaintext">{{ $order->mobile_no ?? '-' }}</p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Salesman</label>
        <p class="form-control-plaintext">
            {{ $order->sales_person_detail->first_name }} {{ $order->sales_person_detail->last_name }}
        </p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Transport</label>
        <p class="form-control-plaintext">{{ $order->transport ?? '-' }}</p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Freight</label>
        <p class="form-control-plaintext">{{ $order->freight ?? '-' }}</p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">GST No.</label>
        <p class="form-control-plaintext">{{ $order->gst_no ?? '-' }}</p>
    </div>

    <div class="col-md-4 mb-3">
        <label class="col-form-label">Address</label>
        <p class="form-control-plaintext">{{ $order->address ?? '-' }}</p>
    </div>

    @if ($order->payment_discount)
        <div class="col-md-4 mb-3">
            <label class="col-form-label">Advance Payment Discount</label>
            <p class="form-control-plaintext">
                {{ $order->payment_discount }}{{ $order->discount_type == 'rupees' ? '₹' : '%' }}</p>
        </div>
    @endif
</div>

<div class="table-responsive table-data-cls">
    <table class="table table-view addnewfield">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Product Name</th>
                <th scope="col">GST(%)</th>
                <th scope="col">Packing Size</th>
                <th scope="col">Price</th>
                <th scope="col">QTY</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody id="table-body">
            @foreach ($order->products as $index => $p)
                <tr class="field-group">
                    <td data-label="S.No.">{{ $index + 1 }}</td>
                    <td data-label="Product Name">
                        <p class="form-control-plaintext">
                            {{ $p->product->product_name ?? '-' }}
                        </p>
                    </td>
                    <td data-label="gst">
                        <p class="form-control-plaintext">{{ $p->gst ?? '-' }}</p>
                    </td>
                    <td data-label="Packing Size">
                        <p class="form-control-plaintext">
                            {{ $p->variation_option ? $p->variation_option->value : '-' }}
                        </p>
                    </td>
                    <td data-label="Price">
                        <p class="form-control-plaintext">{{ $p->price ?? '-' }}</p>
                    </td>
                    <td data-label="QTY">
                        <p class="form-control-plaintext">{{ $p->qty ?? '-' }}</p>
                    </td>
                    <td data-label="Total">
                        <p class="form-control-plaintext">{{ $p->total ?? '-' }}</p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="gstsec mt-4 mb-4">
    <div class="totalsec text-end">
        {{--  <div class="row">
            <div class="col-md-12">
                <div class="price-cls-new">
                    <label class="col-form-label">Total :</label>
                    <p class="form-control-plaintext">{{ IndianNumberFormat($order->total_order_amount) ?? '-'}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="price-cls-new">
                    <label class="col-form-label">GST ({{ $order->gst }}%) :</label>
                    <p class="form-control-plaintext">{{ IndianNumberFormat($order->gst_amount) ?? '-'}}</p>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="price-cls-new">
                    <label class="col-form-label" id="product_total_order_amount">Total Amount :
                        {{ IndianNumberFormat($order->total_order_amount) ?? '0' }} </label>
                </div>
                <div class="price-cls-new">@php
                    $sign = $order->discount_type === 'rupees' ? '₹' : '%';
                    if (!empty($order->payment_discount) && $sign) {
                        $discount = $sign === '₹' ? $sign . $order->payment_discount : $order->payment_discount . $sign;
                    } else {
                        $discount = '0';
                    }
                @endphp
                    <label class="col-form-label" id="discount">Discount : {{ $discount }} </label>
                </div>
                <div class="price-cls-new">
                    <label class="col-form-label">Grand Total (Incl. GST) :</label>
                    <p class="form-control-plaintext">{{ IndianNumberFormat($order->grand_total) ?? '0' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
