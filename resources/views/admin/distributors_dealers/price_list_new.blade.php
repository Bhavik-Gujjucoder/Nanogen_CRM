<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Price List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


        .note-box {
            padding-left: 15px;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background-color: #0d47a1;
            font-family: "Poppins", sans-serif !important;
        }

        .img-cls-new img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .cover-content .price-list {
            position: absolute;
            top: 4%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            text-align: center;
        }

        .cover-content img,
        .mayank-logo {
            width: auto;
            height: auto;
            /* object-fit: cover; */

            margin: auto auto 20px auto;
        }

        .unit-text {
            color: #034EAA;
            font-size: 16px;
            font-weight: 400;
            padding-bottom: 10px;
            margin: 0;
            line-height: normal;
            margin-bottom: 0 !important;
        }


        .img-cls-new {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .brand {
            position: absolute;
            bottom: 1.8%;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            font-size: 20px;
            text-align: center;
            font-weight: bold;
        }

        .bg-img {
            height: 100vh;
        }

        /* table css */
        .container {
            /* background: url('images/table-bg.png')white no-repeat bottom; */
            background-color: #fff;
            border-radius: 20px;
            padding: 30px 10px !important;
            margin: 0 15px;
            display: block;
            min-height: 100vh;
            /* overflow: hidden; */
            height: 92%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header img {
            height: auto;
            width: 140px;
        }

        .pricelist-tag {
            background-color: #72c02c;
            color: white;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 0px;
            font-size: 16px;
            padding-right: 60px;
            width: 10%;
            right: 0;
            margin-top: 15px;
            position: absolute;
            height: 20px;
        }

        .section-title {
            background-color: #72c02c;
            color: white;
            font-weight: bold;
            padding: 3px 10px;
            font-size: 24px;
            margin-top: 10px;
            display: inline-block;
            left: 0;
            text-align: left;
            padding-left: 30px;
            padding-right: 30px;
            position: absolute;
        }

        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }



        /* .logo-img {
            width: 140px;
            height: auto;
        } */

        .header-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
            background-color: transparent;
            /* Ensure no background */
            border: none;
        }

        .header-table td {
            background-color: transparent;
            /* Remove background from cells too */
            vertical-align: middle;
            border: none;
        }

        /* .logo-img {
            width: 140px;
            height: auto;
        } */

        .table-cls {
            margin-top: 70px;
        }

        .table-cls {
            width: 100%;
            /* border-collapse: collapse; */
            text-align: left;
            page-break-inside: avoid;
        }

        table {
            border-spacing: 10px;
        }

        .table-cls thead th {
            background-color: #0B4FA9;
            color: white;
            font-weight: bold;
            padding: 10px 0;
            /* font-weight: lighter; */
            font-size: 14px;
            text-align: center;
        }

        .product-name {
            color: #004b92;
            /* display: block; */
            vertical-align: top;
        }

        table td span {
            padding: 0;
            /* height: 32px; */
            display: block;
        }

        table tr th {
            padding-left: 30px;
            /* display: block; */
        }



        table tr td {
            background-color: #f3f9fd;
            font-weight: normal;
            padding: 0 10px;
        }


        /* Alternate row shading */
        table tr:nth-child(even) td {
            background-color: #e3e9fa;
            font-weight: normal;
        }




        .product-name {
            text-transform: uppercase;
            padding: 15px 30px;
            background-color: #EDF8FA;
            margin: 0;
        }

        .count-name {

            font-weight: normal;
            font-size: 14px;
            color: #0D0D0D;
            /* color: #004b92; */
        }

        .count-name small {
            font-weight: bold;
            font-size: 16px;
        }

        .price-cls {
            color: #0D0D0D;
            font-weight: bold;
            font-size: 20px;
        }

        .table-cls tbody tr:nth-child(even) .product-name {
            background-color: #dbe3f8;
        }

        .gst-cls {
            font-size: 12px;
        }

        /* secong table css */
        .sub-heading {
            color: #0B4FA9;
            font-weight: bold;
            margin-top: 90px;
            position: relative;
            width: 100%;
        }

        .sub-heading::after {
            position: absolute;
            background-color: #0B4FA9;
            width: 420px;
            height: 2px;
            left: 38%;
            top: 10px;
            z-index: 9999;
            content: "";
        }

        .second-table-cls .product-name {
            /* width: 100px; */
            padding: 0;
            font-size: 20px;
        }

        .second-table-cls .product-name span {
            /* padding: 0; */
            font-size: 16px;
        }

        .product-namec-cls {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0px 0 00px 10px;
            display: block;
        }

        .second-table-cls .tbody-cls {
            border-bottom: 1px solid #C8DEF2;
            border-left: 1px solid #C8DEF2;
            /* padding: 30px; */
            width: 100%;
        }

        .tbody-cls .product-name .bag-cls {
            border-bottom: 1px solid #C8DEF2;
        }

        .second-table-cls {
            margin-top: 20px;
        }

        .product-wrap {
            padding: 8px;
        }

        .tbody-cls .product-wrap {
            width: 100px;
            text-align: center;
        }

        .product-id {
            width: 150px;
        }

        .note-box {
            margin-top: 30px;
            line-height: 1.8;

        }

        .note-box ul {
            padding-left: 20px;
        }

        .note-box li {
            margin-bottom: 0px;
            list-style: auto;
            font-size: 12px;
        }

        .footer-cls-new .header-logo {
            text-align: center;
            margin: auto;
            width: 75%;
        }

        .header-logo img {
            margin-left: 40px;
        }

        .footer-content {
            background-color: #0d47a1;
        }

        .footer-content p,
        .footer-content a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
        }

        .footer-content p {
            margin-top: 50px;
        }

        .contact-cls img {
            width: 20px;

            margin-right: 5px;

        }

        .contact-cls a {
            margin-right: 20px;
            font-size: 16px;
        }

        .contact-cls {
            margin-top: 20px;

        }



        .foter-cls-new {
            background-color: #0d47a1;
            z-index: 99999;



        }

        .header-tag-cell {
            text-align: right;
        }

        .credit-table {
            margin-top: 60px;

        }

        .credit-table th,
        .credit-table td {
            padding: 15px;
            background-color: #e3e9fa;
            font-weight: bold;
        }

        /* Left green column */
        .credit-table .head-green {
            background-color: #84bd00;
            color: #ffffff;
            text-align: left;
        }

        .note-sec {
            font-size: 14px;
        }

        .footer-table {
            background-color: #0d47a1;
            padding: 20px 30px;
            color: #ffffff;
            position: absolute;
            bottom: 13%;
            left: 0;
            width: 100%;

        }

        .footer-table td {
            vertical-align: middle;
            background-color: #0d47a1;
        }

        .footer-left {
            width: 65%;
        }

        .footer-left h4 {
            margin: 0 0 6px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .footer-left p {
            margin: 0 0 0px;
            font-size: 14px;
            line-height: 1.4;
        }

        .contact-cls span {
            display: inline-flex;
            align-items: center;
            margin-right: 18px;
            font-size: 14px;
        }

        .contact-cls img {
            width: 16px;
            margin-right: 6px;
        }

        .footer-right {
            width: 35%;
            text-align: right;
        }

        .unit-text {
            margin: 0 0 6px;
            font-size: 13px;
            opacity: 0.9;
        }

        .mayank-logo {
            height: 36px;
            margin-bottom: 6px;
        }

        .web-cls {
            font-size: 14px;
        }

        .web-cls strong {
            font-weight: 700;
        }
    </style>

</head>
{{-- {{dd(public_path('fonts\NotoSansGujarati-Regular.ttf'))}} --}}

<body>
    <div class="img-cls-new">
        <img src="images/price-list-pdf-img/slider-image-new.png" class="bg-img" alt="Background Image">
        <div class="cover-content">
            <div class="price-list">
                <img src="images/price-list-pdf-img/text-img.png" class="logo-text" alt="Logo">
                <img src="images/price-list-pdf-img/new-logo.png" class="logo" alt="Logo">
                <p class="unit-text ">A Unit of</p>
                <img src="{{ public_path('storage/pdf_logo/' . getsetting('pdf_logo')) }}" class="mayank-logo"
                    alt="Mayank Logo">
            </div>
            <h1 class="brand">www.<strong>nanogenagrochem</strong>.com </h1>
            <!-- <h1 class="brand">PRICELIST – {{ now()->year }} <br><span>MONTH</span></h1> -->
        </div>
    </div>
    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/price-list-pdf-img/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <img src="images/price-list-pdf-img/text-img-2.png" alt="Nanogen Logo" class="logo-imgs">
                    </td>
                </tr>
            </table>
            @php $gst = getSetting('gst'); @endphp
            @if ($category)
                @foreach ($category as $c)
                    {{-- <div class="section-title section-ribbon">{{ $c->category_name }}
        </div> --}}
                    <table>
                        <tr>
                            <td>
                                <div class="section-title section-ribbon">{{ $c->category_name }}</div>
                            </td>
                            <td class="header-tag-cell">
                                <!-- <div class="pricelist-tag">PRICELIST – {{ now()->year }}</div> -->
                                <div class="pricelist-tag"></div>
                            </td>
                        </tr>
                    </table>

                    <table class="table-cls ">
                        <thead>
                            <tr>
                                <th>PRODUCT NAME</th>
                                <th>WEIGHT</th>
                                {{-- <th> {{ request()->dealer == 1 ? 'DEALER' : 'DISTRIBUTOR' }}<br> RATE <br> <span
                                        class="gst-cls">(without GST)</span></th> --}}
                                <th>PRICE<br> PER UNIT<br> (without GST) </th>
                                {{-- <th>GST {{ $gst }}%</th> --}}
                                <th>GST %</th>
                                <th>PRICE<br> PER UNIT<br> (With GST) </th>
                                <th class="tablespace-bottom">MRP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($c->products && count($c->products))
                                @foreach ($c->products as $p)
                                    @php $variations = $p->product_variations; @endphp
                                    @if ($variations && count($variations))
                                        @foreach ($variations as $index => $variation)
                                            @php
                                                // dd($p->gst);
                                                $price =
                                                    request()->dealer == 1
                                                        ? $variation->dealer_price
                                                        : $variation->distributor_price;
                                                // $gst_amount = ($price * $gst) / 100;
                                                $product_gst = (float) ($p->gst ?? 0);
                                                $gst_amount = ($price * $product_gst) / 100;
                                                $mrp = $price + $gst_amount;
                                            @endphp
                                            <tr class="spacing-cls">
                                                @if ($index === 0)
                                                    <td class="product-name " rowspan="{{ $variations->count() }}">
                                                        <div class="count-name">{{ $p->product_name }}<br>
                                                            @if ($p->gst)
                                                                <small>{{ 'GST (' . $p->gst . '%)' }}</small>
                                                            @endif
                                                        </div>
                                                        {{-- PRODUCT NAME --}}
                                                    </td>
                                                @else
                                                @endif
                                                <td>
                                                    <span
                                                        class="first-count">{{ $variation->variation_option_value->value }}
                                                        {{ $variation->variation_option_value->unit }}</span>{{-- WEIGHT --}}
                                                </td>
                                                <td>
                                                    <span class="first-count">{{ $price }}</span>
                                                    {{-- DEALER RATE --}}
                                                </td>
                                                <td>
                                                    <span class="first-count">{{ $gst_amount }}</span>
                                                    {{-- GST % --}}
                                                </td>
                                                <td>--!!--</td>
                                                <td>
                                                    <span class="first-count">{{ $mrp }}</span>
                                                    {{-- MRP --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No product available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>


    {{-- gujrati content --}}
    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/price-list-pdf-img/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <img src="images/price-list-pdf-img/text-img-2.png" alt="Nanogen Logo" class="logo-imgs">
                    </td>
                </tr>
            </table>

            <table class="price-lst-section">
                <tr>
                    <td>
                        <div class="section-title">PRICELIST – {{ now()->year }}</div>
                    </td>
                </tr>
            </table>
            <table class="credit-table">
                <thead>
                    <tr>
                        <th class="head-green">DAYS</th>
                        <th>ADVANCE</th>
                        <th>15 DAYS</th>
                        <th>30 DAYS</th>
                        <th>45 DAYS</th>
                        <th>60 DAYS</th>
                        <th>90 DAYS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="head-green">DISCOUNT</th>
                        <td>{{ getSetting('advance') }}</td>
                        <td>{{ getSetting('15_days') }}</td>
                        <td>{{ getSetting('30_days') }}</td>
                        <td>{{ getSetting('45_days') }}</td>
                        <td>{{ getSetting('60_days') }}</td>
                        <td>{{ getSetting('90_days') }}</td>
                    </tr>
                </tbody>
            </table>


            <table class="price-lst-section" style="padding-top: 40px;">
                <tr>
                    <td>
                        <div class="section-title">Terms & Conditions</div>
                    </td>
                </tr>
            </table>
            {{-- <div class="section-title section-ribbon">Quantity scheme</div>
                <div class="sub-heading">WATER SOLUBLE FERTILISERS</div>
                <table class="table-cls second-table-cls">
                    <tbody>
                        <tr class="tbody-cls">
                            <td class="product-namec-cls product-id">calcium nitrate</td>
                            <td class="product-name product-id">
                                <span class="count-name bag-cls">BAG (25KG)</span>
                                <span class="count-name">RS.</span>
                            </td>
                            <td class="product-wrap">
                                <span class="first-count">1 kg</span>
                                <span class="second-count">25</span>
                            </td>
                            <td class="product-wrap">
                                <span class="first-count">1 kg</span>
                                <span class="second-count">25</span>
                            </td>
                            <td class="product-wrap">
                                <span class="first-count">1 kg</span>
                                <span class="second-count">25</span>
                            </td>
                            <td class="product-wrap">
                                <span class="first-count">1 kg</span>
                                <span class="second-count">25</span>
                            </td>
                            <td class="product-wrap" style=visibility:hidden;>
                                <span class="first-count"></span>
                                <span class="second-count">25</span>
                            </td>
                        </tr>
                    </tbody>
                </table> --}}

            <div class="note-box">
                {!! getSetting('terms_and_condition') !!}

                {{-- <ul>
                    <li>The Above-mentioned Prices Are From <strong>Nanogen Agrochem Godown</strong> </li>
                    <li>FOR (Freight on Road) Will Be Provided On Orders of 5 Tons or More. (unloading Will Not Be
                        Provided.)</li>
                    <li>As Soon As The Goods/material Reach Your Godown, The Quality Must Be Checked Immediately. If
                        There Is Any Problem, It
                        Must Be Reported Within 24 Hours Of Receipt. After That, No Complaints Will Be Entertained.
                    </li>

                    <li>If The Stock Remains In Your Godown For A Long Time And Any Issue Arises, The Company Will Not
                        Be Held Responsible</li>
                    <li>If The Credit Period Exceeds 90 Days, An Additional 18% Interest Will Be Charged</li>
                    <li>All Material Supply Is Subjected To Availability Of Stock And Confirmation By The Company</li>
                    <li>Material Once Supplied Will Not Be Taken Back Under Any Circumstances.</li>
                    <li>All The Disputes Are Subject To Rajkot Jurisdiction Only.</li>
                </ul>
                <div class="note-sec"><strong>Note </strong> : Magnesium Sulphate and Bentonite Sulphur are not
                    applicable under the advance booking scheme</div> --}}
            </div>

            {{-- <p style="font-family: noto_sans_gujarati; font-size: 14px;">{!! $gujaratiText !!}</p> --}}

            <table class="price-lst-section" style="padding-top: 40px;">
                <tr>
                    <td>
                        <div class="section-title">Disclaimer:</div>
                    </td>
                </tr>
            </table>
            <div class="note-box" style="padding-top: 30px;">
                {{-- <strong>Management reserves the right to
                    change/modify/withdraw the price-list and its products at any
                    time without any prior notice.</strong> --}}
                {!! getSetting('disclaimer') !!}
            </div>

        </div>

    </div>
    {{-- end --}}

    <table class="footer-table" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="footer-left">
                <h4>{{ getSetting('pdf_footer_name') ?? '-' }}</h4>
                <p>
                    {{ getSetting('pdf_footer_address') ?? '-' }}
                </p>

                <div class="contact-cls">
                    <span>
                        <img src="images/price-list-pdf-img/call-footer.png" alt="">
                        {{ getSetting('pdf_footer_mobile') ?? '-' }}
                    </span>
                    <span>
                        <img src="images/price-list-pdf-img/mail-footer.png" alt="">
                        {{ getSetting('pdf_footer_email') ?? '-' }}
                    </span>
                </div>
            </td>

            <td class="footer-right">
                <p class="unit-text">A Unit of</p>
                <img src="{{ public_path('storage/pdf_logo/' . getsetting('pdf_logo')) ?? '-' }}" class="mayank-logo"
                    alt="Mayank Logo">

                <div class="web-cls">
                    <strong>{{ getSetting('pdf_footer_url') ?? '-' }}</strong>
                </div>
            </td>
        </tr>
    </table>


</body>

</html>
