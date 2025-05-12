{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td style="border-bottom: 1px solid #ddd;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">Hi Admin,</p>
                    <p style="margin-top: 0px;">I hope this message finds you well.</p>
                </td>
            </tr>
            <tr>
                <td style="color: #000000;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom:12px;margin-top: 40px;">
                       Please find below the sales performance summary for {{$data['monthyear']}}:
                    </p>
                    <p style="font-size: 16px;"><b>📈 Key Highlights: </b></p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Total Sales :</b> {{number_format($data['total_sales'], 2)}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Top Performing Product/Service: </b>{{$data['top_product']}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Top Performing Sales person: </b> {{$data['top_sales_person']}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Top Performing Sales Area: </b> {{$data['top_dd_id']}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Sales Growth: </b> {{number_format($data['sales_growth'], 2)}}% compared to last month</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;">If you have any questions or need a deeper analysis, feel free to reach out—I’d be happy to walk you through it.</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}