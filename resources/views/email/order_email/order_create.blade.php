{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td style="border-bottom: 1px solid #ddd;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;"> Hi Admin</p>
                    <p style="margin-top: 0px;margin-bottom: 0px;"><b> Your Order Has Been Placed Successfully! </b></p>
                    <p style="margin-top: 0px;"> Thank You for Your Order! </p>
                </td>
            </tr>
            <tr>
                <td style="color: #000000;">
                    <p style="font-size:14px;font-weight: 400;margin-bottom:12px;margin-top: 40px;">Thank you for placing your order with Nanogen Agrochem. We’re processing it and will keep you updated along the way.</p>
                    <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;"><b>🛒 Order Details:</b></p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>{{ $order->distributors_dealers->user_type == 1 ? 'Distributor' : ($order->distributors_dealers->user_type == 2 ? 'Dealer' : '') }} :</b> {{ $order->distributors_dealers->applicant_name ?? '-'}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Order Number :</b> {{ $order->unique_order_id }}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Order Date :</b> {{ $order->order_date->format('d M Y') ?? '-'}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Phone :</b> {{ $order->mobile_no ?? '-'}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Salesman :</b> {{ $order->sales_person_detail->first_name }} {{ $order->sales_person_detail->last_name }}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Transport :</b> {{ $order->transport ?? '-'}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Freight :</b> {{ $order->freight ?? '-'}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>GST No. :</b> {{ $order->gst_no ?? '-'}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Grand Total Amount :</b> {{ $order->grand_total ?? '-'}}</p>
                    <p style="margin-top: 0px;"><b>Shipping Address :</b>{{ $order->address ?? '-'}}</p>
                </td>
            </tr>   

            <div style="width: 100%; overflow-x: auto;">
                <table cellpadding="0" cellspacing="0" border="1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 8px; text-align: left;">S.No</th>
                            <th style="padding: 8px; text-align: left;">Product Name</th>
                            <th style="padding: 8px; text-align: left;">Packing Size</th>
                            <th style="padding: 8px; text-align: left;">Price</th>
                            <th style="padding: 8px; text-align: left;">QTY</th>
                            <th style="padding: 8px; text-align: left;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $index => $p)
                        <tr>
                            <td style="padding: 8px;">{{ $index + 1 }}</td>
                            <td style="padding: 8px;">{{ $p->product->product_name ?? '-' }}</td>
                            <td style="padding: 8px;">{{ $p->variation_option ? $p->variation_option->value : '-' }}</td>
                            <td style="padding: 8px;">{{ $p->price ?? '-' }}</td>
                            <td style="padding: 8px;">{{ $p->qty ?? '-' }}</td>
                            <td style="padding: 8px;">{{ $p->total ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; margin-bottom: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                <div style="text-align: right;">
                    <div style="margin-bottom: 8px;">
                        <strong>Total:</strong>
                        <span style="margin-left: 10px;">
                            {{ isset($order->total_order_amount) ? sprintf('%.2f', $order->total_order_amount) : '-' }}
                        </span>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>GST ({{ $order->gst }}%):</strong>
                        <span style="margin-left: 10px;">
                            {{ isset($order->gst_amount) ? sprintf('%.2f', $order->gst_amount) : '-' }}
                        </span>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Grand Total (Incl. GST):</strong>
                        <span style="margin-left: 10px;">
                            {{ isset($order->grand_total) ? sprintf('%.2f', $order->grand_total) : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}