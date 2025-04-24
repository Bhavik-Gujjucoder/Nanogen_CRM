<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Price List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        @font-face {
            font-family: 'Noto Sans Gujarati Medium';
            src: url('../fonts/NotoSansGujarati-Medium.eot');

            src: url('../fonts/NotoSansGujarati-Medium.eot?#iefix') format('embedded-opentype'),
                url('../fonts/NotoSansGujarati-Medium.woff2') format('woff2'),
                url('../fonts/NotoSansGujarati-Medium.woff') format('woff'),
                url('../fonts/NotoSansGujarati-Medium.ttf') format('truetype'),

        }



        /* @font-face {
            font-family: 'Anek Gujarati';
            src: url('../fonts/AnekGujarati-Regular.eot');
            src: url('../fonts/AnekGujarati-Regular.eot?#iefix') format('embedded-opentype'),
                url('../fonts/AnekGujarati-Regular.woff2') format('woff2'),
                url('../fonts/AnekGujarati-Regular.woff') format('woff'),
                url('../fonts/AnekGujarati-Regular.ttf') format('truetype'),
                url('../fonts/AnekGujarati-Regular.svg#Anek Gujarati') format('svg');
        } */

        .note-box {
            font-family: 'Noto Sans Gujarati Medium';
            /* font-family: 'Anek Gujarati'; */
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background-color: #0d47a1;
            font-family: "Poppins", sans-serif;

        }



        .img-cls-new img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .cover-content img {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            width: 500px;
            height: auto;
            object-fit: cover;
            color: #fff;
        }

        .img-cls-new {
            position: relative;
        }

        .brand {
            position: absolute;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            font-size: 30px;
            text-align: center;
            font-weight: bold;
        }

        /* table css */
        .container {
            background: url('images/table-bg.png')white no-repeat bottom;
            border-radius: 20px;
            padding: 20px !important;
            margin: 0 40px;
            display: block;
            min-height: 100vh;
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
            width: auto;
            right: 0;
            position: absolute;
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
            padding-left: 60px;
            position: absolute;
        }

        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .header-logo {
            width: 70%;
        }

        .logo-img {
            width: 140px;
            height: auto;
        }

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

        .logo-img {
            width: 140px;
            height: auto;
        }

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
            display: block;
        }

        table td span {
            padding: 13px 10px;
            /* height: 32px; */
            display: block;
        }

        table tr th {
            padding-left: 30px;
            /* display: block; */
        }

        .first-count {
            background-color: #E3F7FE;
            font-weight: normal;
        }

        .second-count {
            background-color: #C8DEF2;
            font-weight: normal;
        }

        .product-name {
            text-transform: uppercase;
            padding: 24px 30px;
        }

        .count-name {
            font-family: 'Poppins', sans-serif !important;
            font-weight: normal;
            font-size: 14px;
            color: #0D0D0D;
            /* color: #004b92; */
        }

        .price-cls {
            color: #0D0D0D;
            font-weight: bold;
            font-size: 20px;
        }

        .table-cls tbody tr:nth-child(even) .product-name {
            background-color: #EDF8FA;
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

        .second-table-cls {
            border-collapse: collapse;
            /* important for clean table borders */
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
            /* background-color: white; */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);

            padding: 30px;
            line-height: 1.8;

        }

        .note-box h3 {
            color: #003366;
            margin-bottom: 20px;
        }

        .note-box ul {
            padding-left: 20px;
        }

        .note-box li {
            margin-bottom: 10px;
        }

        .footer-cls-new .header-logo {
            text-align: center;
            margin: auto;
            width: 75%;

            /* height: 100%; */
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
            flex-shrink: 0;
            margin-right: 5px;
            padding-top: 10px;
        }

        .contact-cls a {
            margin-right: 20px
        }

        .contact-cls {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-cls-new {
            position: relative;
            height: 92%;
            /* or whatever height you need */
            /* for visibility */
            color: white;


        }

        .foter-cls-new {
            background-color: #0d47a1;
            z-index: 99999;



        }

        .footer-table {

            width: 90%;
            max-width: 600px;
            margin: auto;
            text-align: center;
        }

        .footer-content {
            text-align: center;
        }

        /* 
        .footer-table {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translate(-50%, -30%);

            contain: "";
            z-index: 99999;


        }

        .foter-cls-new {
            position: relative;
        } */

        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container.foter-cls-new {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            /* push footer to bottom */
            align-items: end;
            position: relative;


        }
    </style>
</head>

<body>
    <div class="img-cls-new">
        <img src="images/nonogen-slider-img.png" class="bg-img" alt="Background Image">
        <div class="cover-content">
            <img src="images/new-logo.png" class="logo" alt="Logo">
            <h1 class="brand">PRICELIST – 2024 <br><span>MONTH</span></h1>
        </div>
    </div>
    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <div class="pricelist-tag">PRICELIST – 2024</div>
                    </td>
                </tr>
            </table>
            <div class="section-title section-ribbon">WATER SOLUBLE FERTILISERS</div>

            <table class="table-cls">
                <thead>
                    <tr>
                        <th>PRODUCT NAME</th>

                        <th>WEIGHT</th>
                        <th>DEALER <br> RATE <br>
                            <span class="gst-cls">(without GST)</span>
                        </th>
                        <th>GST %</th>
                        <th>MRP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>


                </tbody>
            </table>

        </div>
    </div>
    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <div class="pricelist-tag">PRICELIST – 2024</div>
                    </td>
                </tr>
            </table>
            <div class="section-title section-ribbon">WATER SOLUBLE FERTILISERS</div>

            <table class="table-cls">
                <thead>
                    <tr>
                        <th>PRODUCT NAME</th>

                        <th>WEIGHT</th>
                        <th>DEALER <br> RATE <br>
                            <span class="gst-cls">(without GST)</span>
                        </th>
                        <th>GST %</th>
                        <th>MRP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>


                </tbody>
            </table>

        </div>
    </div>
    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <div class="pricelist-tag">PRICELIST – 2024</div>
                    </td>
                </tr>
            </table>
            <div class="section-title section-ribbon">WATER SOLUBLE FERTILISERS</div>

            <table class="table-cls">
                <thead>
                    <tr>
                        <th>PRODUCT NAME</th>

                        <th>WEIGHT</th>
                        <th>DEALER <br> RATE <br>
                            <span class="gst-cls">(without GST)</span>
                        </th>
                        <th>GST %</th>
                        <th>MRP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>
                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="product-name">
                            <div class="count-name">AQUA BOOST</div>
                            <div class="price-cls">19:19:19</div>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>
                        <td>
                            <span class="first-count">1 kg</span>

                            <span class="second-count">25</span>
                        </td>

                    </tr>




                </tbody>
            </table>

        </div>
    </div>
    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <div class="pricelist-tag">PRICELIST – 2024</div>
                    </td>
                </tr>
            </table>
            <div class="section-title section-ribbon">Quantity scheme</div>
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
            </table>
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
            </table>
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
            </table>
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
            </table>
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
            </table>
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
            </table>
        </div>
    </div>

    <div style="padding-top: 40px;">
        <div class="container">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="images/sub-logo.png" alt="Nanogen Logo" class="logo-img">
                    </td>
                    <td class="header-tag-cell">
                        <div class="pricelist-tag">PRICELIST – 2024</div>
                    </td>
                </tr>
            </table>
            <div class="section-title section-ribbon">Quantity scheme</div>
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
            </table>
            <div class="note-box">
                <h3>નોંધ:</h3>
                <ul>
                    <li>ઉપલોકત ભાવ અમારા ગોડાઉન આધારિત છે.</li>
                    <li>૪ ટન ઓર્ડર પર FOR આપવામાં આવશે. (હૉઈર આપવી આપશો નહિ)</li>
                    <li>માલ/મટેરિયલ તમારા ગોડાઉનમાં પહોંચે એટલે તે જ ફટાફટ ચેક કરી લેવી અને કોઈ ઘાટો-ભેમ હોય તો માલ
                        માંગેલા જ ટ્રક ચાલક સાથે જ રીટર્ન કરવા વિનંતી. પછી કંપની ફરીયાદ સાંભળવા માંગતી નથી.</li>
                    <li>તમારા ગોડાઉનના જથ્થા અંગે સમયથી કહી પડે તો અને તો જ કોઇ પ્રશ્ન સર્જાશે તો તેના માટે કંપની
                        જવાબદાર રહેશે નહિ.</li>
                    <li>પેમેન્ટ ડિલે કરવામાં નહીં આવે.</li>
                    <li>પાર્ટીનો ૬ દિવસથી વધારે ક્રેડિટ પીરિયડ પર પેનલ્ટી ૧% વટે હિસાબ ચૂકવવાની રહેશે.</li>
                    <li>ચેકનાં દેવામાં પાઇટી પોતે તેની પરફેક્ટ કંપની પાસેથી પાવર લેશે.</li>
                    <li>માલ પર CST ફોર્મ તથા ઇન્સ્યુરન્સ/એકસાઇઝ/ઓકટ્રોઇસે પર. ટી. ના નામે કરાવવું રહેશે તો કંપની જાણે
                        નહીં.</li>
                    <li>મૂળભૂત ભાવ પર જ માલ દેવા કૉમ્પ્રોમાઇઝ કરવો નહિ.</li>
                    <li>મશીનરી સેટ કરો પછી સેટ નહી થાય તો રિટર્ન ક્લેમ કશું મળવું પડશે નહિ.</li>
                    <li>વ્યાજબાકી કડક રકમેક રહેશે.</li>
                </ul>
            </div>

        </div>
    </div>
    <div style="padding-top: 800px;">
        <div class="container foter-cls-new">
            <div class="footer-table">
                <table>
                    <tr>
                        <td class="footer-content">
                            <img src="images/new-logo.png" class="logo" alt="Logo">
                            <p>
                                Revenue Survey No. 162, Mayank Cattle Food Limited Compound,
                                Office No. 1, Rajkot-Jamnagar Highway, Village: Naranka,
                                Rajkot, Gujarat 360 110 INDIA.
                            </p>

                            <div class="contact-cls">
                                <a href="#"><img src="images/call-footer.png" alt="">+91 98253 85584</a>
                                <a href="#"><img src="images/mail-footer.png" alt="">info@nanogenagrochem.com</a>
                            </div>

                            <div class="web-cls">
                                <a href="#">www.<strong>nanogenagrochem</strong>.com</a>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>

        </div>

</body>

</html>