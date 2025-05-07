{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td style="border-bottom: 1px solid #ddd;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">Your Order #1235A6 Has Been Shipped! </p>
                    <p style="margin-top: 0px;">Your Order Is On Its Way!</p>
                </td>
            </tr>
            <tr>
                <td style="color: #000000;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">Hi Admin,</p>
                    <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;"> Your order #1235A6 has been shipped and is on its way to you.</p>
                    <p style="font-size: 16px;"><b>📦 Shipping Details: </b></p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Order Number :</b> #1235A6</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Shipping Date: </b> 25/05/2025</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Transport: </b> Abc</p>
                </td>
            </tr>
        </table>
    </td>
</tr>

{{--Body End--}}

{{ view('email.footer') }}
