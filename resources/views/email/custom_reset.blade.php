{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
            <td style="color: #000000;padding-bottom: 40px;">
                <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">Hello,</p>
                <p style="font-size: 16px;line-height: 24px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">You are receiving this email because we received a request to reset the password for your account.</p>
                <p style="font-size: 16px;background-color: #5271ff;margin: auto;border-radius: 10px;text-align: center;padding:8px;max-width: 150px;margin: auto;margin-top: 40px;"><a href="{{$actionUrl}}" style="color:#fff;text-decoration: none;">Reset Password</a></p>
            </td>
            </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}