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
                <p style="margin-bottom: 5px;margin-top: 0px;"><b>Dealer :</b> Pratap Pandya</p>
                <p style="margin-bottom: 5px;margin-top: 0px;"><b>Order Number :</b> 012345</p>
                <p style="margin-bottom: 5px;margin-top: 0px;"><b>Order Date :</b> 25/05/2025</p>
                <p style="margin-bottom: 5px;margin-top: 0px;"><b>Total Amount :</b> 5000</p>
                <p style="margin-bottom: 5px;margin-top: 0px;"><b>Payment Method :</b> Online</p>
                <p style="margin-top: 0px;"><b>Shipping Address :</b> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td>
            </tr>
        
            </td>
        </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}