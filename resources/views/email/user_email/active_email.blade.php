{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
            <td style="border-bottom: 1px solid #ddd;">
                <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">Your Account Has been Activated</p>
            </td>
            </tr>
            <tr>
            <td style="color: #000000;">
                <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">Hi {{$data['name']}},</p>
                <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">Thank you for your interest in Nanogen Agrochem. We're pleased to inform you that your account has been successfully approved and activated.</p>
                <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">You can now log in and start accessing our products and services. If you have any questions or need assistance, feel free to contact us at <a href="mailto:info@nanogen.com">info@nanogen.com</a>.</p>
                <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">We look forward to serving you and supporting your success in the agrochemical industry.</p>
            </td>
            </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}