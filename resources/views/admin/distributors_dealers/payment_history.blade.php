@extends('layouts.main')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        label {
            display: inline-block;
            width: 200px;
            margin-bottom: 10px;
        }

        input,
        select {
            padding: 5px;
            width: 200px;
        }

        h2 {
            margin-top: 30px;
        }

        .hidden {
            display: none;
        }

        table {
            margin-top: 40px;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
@section('title')
    {{ $page_title }}
@endsection
<div class="card">
    <div class="card-body">
        <div class="row">

            <!-- Dealer or Distributor Name -->
            <div class="col-md-4 mb-3">
                <label class="col-form-label">Dealer or Distributor Name : </label> {{ $distributor_dealers->applicant_name }}
            </div>

            <!-- Overdue Amount -->
            <div class="col-md-4 mb-0">
                <label class="col-form-label">Overdue Amount : 0 </label>
               
            </div>

        </div>

        <!-- Heading -->
        <h5 class="mt-4">Submit Payment</h5>

        <div class="row">

            <!-- Amount -->
            <div class="col-md-4 mb-3">
                <label class="col-form-label">Amount</label>
                <input type="number" name="amount" class="form-control" placeholder="Amount">
            </div>

            <!-- Payment Type -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="col-form-label">Payment Type</label>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <input type="radio" class="status-radio" id="payment_online" name="payment_type" value="Online" onchange="handlePaymentTypeChange(this.value)">
                            <label for="payment_online" class="ms-1">Online</label>
                        </div>
                        <div>
                            <input type="radio" class="status-radio" id="payment_cash" name="payment_type" value="Cash" onchange="handlePaymentTypeChange(this.value)">
                            <label for="payment_cash" class="ms-1">Cash</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Online Platform -->
            <div class="col-md-4 mb-3" id="onlinePlatformDiv" style="display: none;">
                <label class="col-form-label">Online Payment Platform</label>
                <select class="form-control" name="payment_platform" onchange="handlePlatformChange(this.value)">
                    <option value="">Select Platform</option>
                    <option value="GPay">GPay</option>
                    <option value="PhonePe">PhonePe</option>
                    <option value="Paytm">Paytm</option>
                    {{-- <option value="Other">Other</option> --}}
                </select>
            </div>

            <!-- Transaction ID -->
            <div class="col-md-4 mb-3" id="transactionIdDiv" style="display: none;">
                <label class="col-form-label">Transaction ID</label>
                <input type="text" name="transaction_id" class="form-control" placeholder="Transaction ID">
            </div>

        </div>

        <!-- Transaction Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered" id="payment_history_table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Transaction Type</th>
                        <th>Transaction ID</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows go here -->
                    <tr>
                        <td>1</td>
                        <td>22/04/2025</td>
                        <td>100000</td>
                        <td>Cash</td>
                        <td>-</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>








    function handlePaymentTypeChange(value) {
        const platformDiv = document.getElementById('onlinePlatformDiv');
        const transactionDiv = document.getElementById('transactionIdDiv');
        if (value === 'Online') {
            platformDiv.style.display = 'block';
        } else {
            platformDiv.style.display = 'none';
            transactionDiv.style.display = 'none';
        }
    }

    function handlePlatformChange(value) {
        const transactionDiv = document.getElementById('transactionIdDiv');
        if (value !== '') {
            transactionDiv.style.display = 'block';
        } else {
            transactionDiv.style.display = 'none';
        }
    }
</script>
@endsection
