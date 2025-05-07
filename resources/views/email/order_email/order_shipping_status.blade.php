{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td style="border-bottom: 1px solid #ddd;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">Your Order #{{$order->unique_order_id}} Has Been Shipped! </p>
                    <p style="margin-top: 0px;">Your Order Is On Its Way!</p>
                </td>
            </tr>
            <tr>
                <td style="color: #000000;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">
                        @if($order->admin_email)
                            Hi Admin,
                        @else
                            Hi {{ $order->sales_person_detail->first_name }} {{$order->sales_person_detail->last_name}},
                        @endif
                    </p>
                    <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;"> Your order #{{$order->unique_order_id}} has been shipped and is on its way to you.</p>
                    <p style="font-size: 16px;"><b>📦 Shipping Details: </b></p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Order Number :</b> #{{$order->unique_order_id}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Shipping Date: </b>{{ $order->shipping_date ? \Carbon\Carbon::parse($order->shipping_date)->format('d M Y') : '-' }}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Party Name: </b> {{ $order->distributors_dealers->applicant_name ?? '-'}} {{ $order->distributors_dealers->user_type == 1 ? '(Distributor)' : ($order->distributors_dealers->user_type == 2 ? '(Dealer)' : '') }}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Phone: </b> {{$order->mobile_no}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Salesman: </b> {{$order->sales_person_detail->first_name}} {{$order->sales_person_detail->last_name}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Transport: </b> {{$order->transport}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Address: </b> {{$order->address}}</p>
                </td>
            </tr>
        </table>
    </td>
</tr>

{{--Body End--}}

{{ view('email.footer') }}
