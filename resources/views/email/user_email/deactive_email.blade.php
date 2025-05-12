{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
            <td style="border-bottom: 1px solid #ddd;">
                <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">Your Account Has been Deactivated</p>
            </td>
            </tr>
            <tr>
            <td style="color: #000000;">
                <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">Hi {{$data['name']}},</p>
                <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">Thank you for your interest in Nanogen Agrochem after careful review, we’re unable to approve your account at this time. </p>
                <p  style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">If you believe this was a mistake or would like to provide additional information, please feel free to reach out to us at <a href="info@nanogen.com">info@nanogen.com</a></p>
                <p  style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">We truly appreciate your interest and hope to have the opportunity to serve you in the future.</p>
            </td>
            </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}