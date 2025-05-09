{{ view('email.header') }}

{{-- Body Start --}}
<tr>
    <td style="padding:0px; background-color:#ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td style="border-bottom: 1px solid #ddd;padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom: 5px;">New Sales Target Set</p>
                    <p style="margin-top: 0px;">Let’s achieve great results together!</p> 
                </td>
            </tr>
            <tr>
                <td style="color: #000000; padding:0px 15px;">
                    <p style="font-size:18px;font-weight: 600;margin-bottom:0px;margin-top: 40px;"> 
                        @if($target->admin_email)
                            Hi Admin,
                        @else
                            Hi {{ $target->sales_person_detail->first_name }} {{$target->sales_person_detail->last_name}},
                        @endif
                    </p>
                    <p style="font-size: 16px;line-height: 28.8px;font-weight: 400;margin-top: 0;margin-bottom:30px;"> A new sales target has been established to guide the upcoming sales efforts. The goal is to drive performance and exceed expectations.</p>
                
                    <p style="font-size: 16px;"><b>💰 Target Summary</b></p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Target Name :</b> {{$target->subject}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Salesman: </b> {{$target->sales_person_detail->first_name}} {{$target->sales_person_detail->last_name}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Region: </b> {{$target->city->city_name}}</p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Target Value : </b> {{$target->target_value}} </p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>Start Date : </b> {{ $target->start_date ? \Carbon\Carbon::parse($target->start_date)->format('d M Y') : '-' }} </p>
                    <p style="margin-bottom: 5px;margin-top: 0px;"><b>End Date : </b> {{ $target->end_date ? \Carbon\Carbon::parse($target->end_date)->format('d M Y') : '-' }} </p>              
                </td>
            </tr>
        </table>
    </td>
</tr>
{{--Body End--}}

{{ view('email.footer') }}