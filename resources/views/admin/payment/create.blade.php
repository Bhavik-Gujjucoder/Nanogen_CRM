@extends('layouts.main')
@section('content')
@section('title')
{{ $page_title }}
@endsection
<div class="card paymet-cls-wraps">
    <div class="card-header paymet-cls">
        <div class="row">
            <div class="col-sm-3">
                <div class="mb-3">
                    <label class="col-form-label">Customer Name ( Dealers or Destributors )<span class="text-danger">
                            *</span></label>
                    <select class="select search-dropdown">
                        <option selected>Choose</option>
                        <option>Jayesh Patel</option>
                        <option>Karan Virani</option>
                        <option>Jayesh Patel</option>
                        <option>Karan Virani</option>
                        <option>Jayesh Patel</option>
                        <option>Karan Virani</option>
                    </select>
                </div>


            </div>
        </div>
        <div class="card-body">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-10">
                        <h4 class="page-title">Unpaid Invoice</h4>
                    </div>
                    <div class="col-2 text-end">
                        <h6 class="fs-medium text-truncate "><a href="">Clear applied amount</a></h6>
                    </div>

                </div>
            </div>
            <div class="table-responsive custom-table">
                <table class="table" id="payments-list">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Order Number</th>
                            <th style="text-align: right;">Order Amount</th>
                            <th style="text-align: right;">Amount Due </th>
                            <th style="text-align: right;">Payment</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd">
                            <td>28 Dec 2023 <br>
                                <span class="due-date-cls">Due Date: <strong>30-08-2018</strong></span>

                            </td>
                            <td>ORD000003</td>
                            <td style="text-align: right;">2,00,000</td>
                            <td style="text-align: right;">2,00,000</td>
                            <td style="text-align: right;"><input type="text" class="form-control" placeholder="2,00,000">
                                <h6 class="fs-medium text-truncate "><a href="">Pay in Full</a></h6>
                            </td>

                        </tr>
                        <tr class="even">
                            <td>28 Dec 2023<br>
                                <span class="due-date-cls">Due Date: <strong>30-08-2018</strong></span>
                            </td>
                            <td>ORD000005</td>
                            <td style="text-align: right;">2,00,000</td>
                            <td style="text-align: right;">2,00,000</td>
                            <td style="text-align: right;"><input type="text" class="form-control" placeholder="2,00,000">
                                <h6 class="fs-medium text-truncate "><a href="">Pay in Full</a></h6>
                            </td>

                        </tr>
                        <tr class="odd" style="border-bottom: transparent;">
                            <td><span>**List contains only SENT Invoice</span></td>
                            <td></td>
                            <td style="text-align: right;">total</td>
                            <td style="text-align: right;">00</td>
                            <td style="text-align: right;"><strong>4,00,000</strong> <br>

                            </td>

                        </tr>


                    </tbody>
                </table>
            </div>
            <table class="table table-bordered payment-summary-table">
                <tbody>
                    <tr>
                        <td class="label-cell">Amount Received :</td>
                        <td class="value-cell">50000.00</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Amount used for payments :</td>
                        <td class="value-cell">40000.00</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Amount Refunded :</td>
                        <td class="value-cell">0.00</td>
                    </tr>
                    <tr class="excess-row">
                        <td class="label-cell warning-label">
                            <i class="fas fa-exclamation-triangle icon-warning"></i> Amount in excess:
                        </td>
                        <td class="value-cell warning-value">Rs. 10000.00</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-end">

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>

    </div>
    @endsection
    @section('script')
    <script>
        $(document).ready(function() {
            $('.search-dropdown').select2({
                placeholder: "Select",
                // allowClear: true
            });
        });
    </script>
    @endsection