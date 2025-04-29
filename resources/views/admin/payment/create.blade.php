@extends('layouts.main')
@section('content')
@section('title')
{{ $page_title }}
@endsection
<div class="card">
    <div class="card-header paymet-cls">
        <div class="row">
            <div class="col-sm-2">
                <div class="dropdown me-2">
                    <a href="" class="dropdown-toggle"
                        data-bs-toggle="dropdown"><i
                            class="ti ti-package-export me-2"></i>Select</a>
                    <div class="dropdown-menu  dropdown-menu-end">
                        <ul>
                            <li>
                                <a href="" class="dropdown-item"><i
                                        class="ti ti-file-type-pdf text-danger me-1"></i>Dealer</a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"><i
                                        class="ti ti-file-type-xls text-green me-1"></i>Distributor </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-4">
                    <h4 class="page-title">Unpaid Invoice</h4>
                </div>

            </div>
        </div>
        <div class="table-responsive custom-table">
            <table class="table" id="payments-list">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Invoce Number</th>
                        <th>Invoce Amount</th>
                        <th>Amount Due </th>
                        <th>Payment</th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="odd">
                        <td>28 Dec 2023</td>
                        <td>
                            123
                        </td>
                        <td>2,00,000</td>
                        <td>2,00,000</td>
                        <td>2,00,000 <br>
                        <span>Pay In Full</span>
                    </td>

                    </tr>


                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@section('script')
<script></script>
@endsection