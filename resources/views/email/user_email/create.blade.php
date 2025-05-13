{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td style="border-bottom: 1px solid #ddd;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">Welcome to Nanogen Agrochem – Let’s Get Started!</p>
                    <p style="margin-top: 0px;">Thank You for Joining Nanogen Agrochem</p>
                </td>
            </tr>
            <tr>
                <td style="color: #000000;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">Hi {{ $data['name'] }},</p>
                    <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom: 20px;">We’re excited to have you on board! With Raj  you’re now equipped to manage your customer relationships, streamline your processes, and grow your business more effectively.</p>
                    <p style="font-size:16px;"><strong>Your Login Details:</strong></p>
                    <p style="margin-bottom: 2px;"><strong>Email : </strong> <span>{{ $data['email'] }}</span></p>
                    <p style="margin-top: 0px;"><strong>Temporary Password : </strong> <span>{{ $data['password'] }}</span></p>
                </td>
            </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}