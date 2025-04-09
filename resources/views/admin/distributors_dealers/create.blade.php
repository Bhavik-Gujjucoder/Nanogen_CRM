@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form id="userForm" action="#">
            <div class="edit-distributorsform">
                <!-- Basic Info -->
                <div class="applicationdtl mb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    <span><i class="ti ti-photo"></i></span>
                                </div>
                                <div class="upload-content">
                                    <div class="upload-btn">
                                        <input type="file">
                                        <span>
                                            <i class="ti ti-file-broken"></i>Upload Profile Picture
                                        </span>
                                    </div>
                                    <p>JPG, GIF or PNG. Max size of 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <!-- Default value when checkbox is NOT checked -->
                            <input type="hidden" name="user_type" value="2">

                            <!-- When checked, this value overrides the hidden input -->
                            <input type="checkbox" id="toggle" name="user_type" value="1"
                                class="toggleCheckbox" />

                            <label for="toggle" class="toggleContainer">
                                <div>Upgrade to distributor</div>
                                <div>Dealers</div>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label"> Application Form No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_form_no" value="{{ old('app_form_no') }}"
                                    class="form-control" placeholder="Application Form No">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Code No <span class="text-danger">*</span></label>
                                <input type="text" name="code_no" value="{{ old('code_no') }}" class="form-control"
                                    placeholder="Code No">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Name of the Applicant <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="applicant_name" value="{{ old('applicant_name') }}"
                                    class="form-control" placeholder="Name of the Applicant">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label"> Name of the Firm/Shop <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="firm_shop_name" value="{{ old('firm_shop_name') }}"
                                    class="form-control" placeholder="Name of the Firm/Shop">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Address of the Firm/Shop <span
                                        class="text-danger">*</span></label>
                                <textarea name="firm_shop_address" class="form-control" placeholder="Address of the Firm/Shop">{{ old('firm_shop_address') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Mobile No <span class="text-danger">*</span></label>
                                <input type="number" name="mobile_no" value="{{ old('mobile_no') }}"
                                    class="form-control" placeholder="Mobile No">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Pan Card No <span class="text-danger">*</span></label>
                                <input type="number" name="pancard" value="{{ old('pancard') }}" class="form-control"
                                    placeholder="Pan Card No">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">GSTIN <span class="text-danger">*</span></label>
                                <input type="text" name="gstin" value="{{ old('gstin') }}" class="form-control"
                                    placeholder="GSTIN">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Aadhar Card No <span class="text-danger">*</span></label>
                                <input type="text" name="aadhar_card" value="{{ old('aadhar_card') }}"
                                    class="form-control" placeholder="Aadhar Card No">
                            </div>
                        </div>
                    </div>
                    {{-- validate form end --}}
                </div>
                <div class="dealerlist mb-3">
                    <label class="col-form-label mright">Are you a registered dealer? <span
                            class="text-danger">*</span></label>
                    <ul class="d-flex">
                        <li class="form-check form-check-md d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="registered_dealer" id="dealerYes"
                                value="yes" {{ old('registered_dealer') == 'yes' ? 'checked' : 'checked' }}>
                            <label class="form-check-label" for="dealerYes">Yes</label>
                        </li>
                        <li class="form-check form-check-md d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="registered_dealer" id="dealerNo"
                                value="no" {{ old('registered_dealer') == 'no' ? 'checked' : '' }}>
                            <label class="form-check-label" for="dealerNo">No</label>
                        </li>
                    </ul>
                </div>
                <div class="applicationdtl mb-3">
                    <h5 class="mb-2">Details of Bank A/c.</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Name and address of Bank <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="bank_name_address"
                                    value="{{ old('bank_name_address') }}" class="form-control"
                                    placeholder="Name and address of Bank">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Account No <span class="text-danger">*</span></label>
                                <input type="text" name="account_no" value="{{ old('account_no') }}"
                                    class="form-control" placeholder="Account No">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code" value="{{ old('ifsc_code') }}"
                                    class="form-control" placeholder="IFSC Code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Details of Security Cheque <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="security_cheque_detail"
                                    value="{{ old('security_cheque_detail') }}" class="form-control"
                                    placeholder="Details of Security Cheque">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.1 </label>
                                <input type="text" name="cheque_1" value="{{ old('cheque_1') }}"
                                    class="form-control" placeholder="Cheque No.1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.2 </label>
                                <input type="text" name="cheque_2" value="{{ old('cheque_2') }}"
                                    class="form-control" placeholder="Cheque No.2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.3 </label>
                                <input type="text" name="cheque_3" value="{{ old('cheque_3') }}"
                                    class="form-control" placeholder="Cheque No.3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Name of authorised signatory <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name_authorised_signatory"
                                    value="{{ old('name_authorised_signatory') }}" class="form-control"
                                    placeholder="Name of authorised signatory">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="listcheck mb-3">
                                <label class="col-form-label">Type of A/c. <span class="text-danger">*</span></label>
                                <ul>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="ac_type" type="radio" value="1"
                                            id="savings" checked>
                                        <label class="form-check-label" for="savings">Savings</label>
                                    </li>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="ac_type" type="radio" value="2"
                                            id="current">
                                        <label class="form-check-label" for="current">Current</label>
                                    </li>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="ac_type" type="radio" value="3"
                                            id="other">
                                        <label class="form-check-label" for="other">Other (Please specify)</label>
                                    </li>
                                </ul>
                            </div>

                            <!-- Hidden input field for "Other" option -->
                            <div id="otherInputField" style="display: none; margin-top: 10px;">
                                <label class="form-check-label" for="current">Please specify other account
                                    type <span class="text-danger">*</span></label>
                                <input type="text" name="other_ac_type" class="form-control"
                                    placeholder="Please specify other account type">
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-md-4 ">
                            <div class="mb-3">
                                <label class="col-form-label">Fertilizer License No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="fertilizer_license"
                                    value="{{ old('fertilizer_license') }}" class="form-control"
                                    placeholder="Fertilizer License No">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Pesticide License No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="pesticide_license "
                                    value="{{ old('pesticide_license ') }}" class="form-control"
                                    placeholder="Pesticide License No">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Seed License No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="seed_license" value="{{ old('seed_license') }}"
                                    class="form-control" placeholder="Seed License No">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="applicationdtl mb-3">
                    <div class="d-flex">
                        <h5 class="mb-3">Name of firm/company under which dealership exist :</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-view addnewfield" id="firmdataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">S. No</th>
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Products</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="S.No.">1</td>
                                            <td data-label="Company Name">
                                                <input type="text" name="company_name[]" value=""
                                                    class="form-control" placeholder="Enter company name">
                                            </td>

                                            {{-- <td data-label="Products">
                                                <input type="text" name="" value=""
                                                    class="form-control" placeholder="Enter Products">
                                            </td> --}}
                                            <td data-label="Products">
                                                <select name="product_id" class="form-control">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td data-label="Quantity">
                                                <input type="number" name="" value=""
                                                    class="form-control" placeholder="Enter quantity">
                                            </td>
                                            <td data-label="Remarks">
                                                <input type="text" name="" value=""
                                                    class="form-control" placeholder="Enter remarks">
                                            </td>
                                            <td data-label="Action">
                                                {{-- <button type="button" onclick="addnewRow()"
                                                    class="btn btn-primary">Add New</button> --}}
                                                <button type="button" id="addNewFirmRow" class="btn btn-primary">Add
                                                    New</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="applicationdtl mb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="listcheck mb-5">
                                <label class="col-form-label">Status of firm
                                    <span class="text-danger">*</span></label>
                                <p class="smallnote">
                                    (For partnership firms enclose copy of partnership Deed
                                    and for Companies Memorandum Articles of Association)
                                </p>
                                <ul>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="1" id="proprietorship">
                                        <label class="form-check-label" for="proprietorship">Proprietorship</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="2" id="partnership">
                                        <label class="form-check-label" for="partnership">Partnership</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="3" id="limitedcompany">
                                        <label class="form-check-label" for="limitedcompany">Limited Company</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="4" id="private">
                                        <label class="form-check-label" for="private">Private Ltd. Co.</label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h5 class="mb-3">Details of Proprietor/Partners/Directors:</h5>
                            <div class="table-responsive">
                                <table class="table table-view addnewfield" id="propertiesdataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date of Birth</th>
                                            <th scope="col">Address</th>
                                            {{-- <th scope="col">Father’s/Husband’s Name</th>
                                            <th scope="col">Marital Status</th> --}}
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="S.No.">1</td>
                                            <td data-label="Name"><input type="text" placeholder="Enter name"
                                                    class="form-control"></td>
                                            <td data-label="Date of Birth" class="dateofbirth">
                                                <div class="icon-form">
                                                    <span class="form-icon"><i
                                                            class="ti ti-calendar-check"></i></span>
                                                    <input type="text" class="form-control datetimepicker"
                                                        placeholder="">
                                                </div>
                                            </td>
                                            <td data-label="Address">
                                                <textarea placeholder="Enter Address" class="form-control"></textarea>
                                            </td>
                                            {{-- <td data-label="Father’s/Husband’s Name"><input type="text"
                                                    placeholder="Father’s/Husband’s Name" class="form-control">
                                            </td>
                                            <td data-label="Marital Status">
                                                <select class="form-control">
                                                    <option>Single</option>
                                                    <option>Married</option>
                                                </select>
                                            </td> --}}
                                            <td>
                                                {{-- <button type="button" onclick="addpropRow()"
                                                    class="btn btn-primary">Add New</button> --}}
                                                <button type="button" id="addNewPropRow" class="btn btn-primary">Add
                                                    New</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Name and address of associate firm(s) <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="associate_name_address"
                                    value="{{ old('associate_name_address') }}" class="form-control"
                                    placeholder="Name and address of associate firm(s)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Indicate number of people employed in your firm
                                    (including active partners)<span class="text-danger">*</span></label>
                                <input type="number" name="indicate_number" value="{{ old('indicate_number') }}"
                                    class="form-control"
                                    placeholder="Indicate number of people employed in your firm">
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label"> Turnover: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="abc">
                            </div>
                        </div> --}}


                    </div>
                </div>
                {{-- <div class="applicationdtl mb-3">
                    <h5 class="mb-3">Details of Security Deposit:</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label"> DD/Cheque No. <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="abc">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="icon-form">
                                    <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                    <input type="text" class="form-control datetimepicker" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label"> Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="Amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label"> Bank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="Bank">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label"> Payable at <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="Payable at ">
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="applicationdtl mb-3">
                    <h5 class="mb-3">Last three years turnover of your firm (in Rs. Lacs/Cores)</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" class="form-control" value=""
                                    placeholder="1st year turnover">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" class="form-control" value=""
                                    placeholder="2nd year turnover">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" class="form-control" value=""
                                    placeholder="3rd year turnover">
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class=" listcheck mb-3">
                                <div class="subcat">
                                    <label class="col-form-label mright">Are you a registered dealer?</label>
                                    <ul>
                                        <li class="form-check form-check-md d-flex align-items-center">
                                            <input class="form-check-input " type="checkbox" value=""
                                                id="Yes">
                                            <label class="form-check-label" for="Current">Yes</label>
                                        </li>
                                        <li class="form-check form-check-md d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="No">
                                            <label class="form-check-label" for="Current">No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Sales Tax registration No<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">GSTIN<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div> --}}
                        <div class="col-md-10">
                            <div class="listcheck mb-3">
                                <label class="col-form-label">Do you have godown facility? <span
                                        class="text-danger">*</span></label>
                                <ul>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="godown_facility" type="radio"
                                            value="yes" id="godown_yes">
                                        <label class="form-check-label" for="godown_yes">Yes</label>
                                    </li>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="godown_facility" type="radio"
                                            value="no" id="godown_no" checked>
                                        <label class="form-check-label" for="godown_no">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <!-- Hidden input field shown when "Yes" is selected -->
                                <div id="godownSizeField" style="display: none; margin-top: 10px;">
                                    <label class="col-form-label">Indicate size and capacity of godown</label>
                                    <input type="text" name="godown_size_capacity" class="form-control"
                                        placeholder="Indicate size and capacity of godown">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Indicate size and capacity of godown.<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="mb-3">
                                <label class="col-form-label">Address of godown<span
                                        class="text-danger">*</span></label>
                                <textarea type="text" name="godown_address" class="form-control" value="" placeholder="Address of godown"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Expected Minimum Sales</label>
                                <input type="text" name="expected_minimum_sales" class="form-control"
                                    placeholder="Expected Minimum Sales">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Place</label>
                                <input type="text" name="place" class="form-control" placeholder="Place">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Date</label>
                                <input type="date" name="date" class="form-control" placeholder="Date">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="col-form-label">Signature of the Employee (S.O - ASM/ TSM/ RSM) </label>
                                <input type="file" name="employee_signature" class="form-control"
                                    accept=".jpg, .jpeg, .png, .pdf">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="col-form-label">Signature of the Applicant(s) (with rubber stamp)
                                </label>
                                <input type="file" name="employee_signature" class="form-control"
                                    accept=".jpg, .jpeg, .png, .pdf">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
                <button type="button" class="btn btn-primary">Create</button>
            </div>
            <!-- /Basic Info -->


        </form>
    </div>
</div>

@endsection
@section('script')
<!-- other account type field  -->
<script>
    $(document).ready(function() {
        $('input[name="ac_type"]').on('change', function() {
            if ($(this).val() === "3") {
                $('#otherInputField').show();
            } else {
                $('#otherInputField').hide();
            }
        });
        // });

        // $(document).ready(function() {
        $('input[name="godown_facility"]').on('change', function() {
            if ($(this).val() === "yes") {
                $('#godownSizeField').show();
            } else {
                $('#godownSizeField').hide();
            }
        });
    });
</script>


{{-- <script>

    let serialNumber = 1;
    function addnewRow() {
        let table = document.getElementById("firmdataTable").getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();

        let serialCell = newRow.insertCell(0);
        let companyCell = newRow.insertCell(1);
        let productCell = newRow.insertCell(2);
        let quantityCell = newRow.insertCell(3);
        let remarksCell = newRow.insertCell(4);
        let actionCell = newRow.insertCell(5);

        serialCell.setAttribute("data-label", "S.No.");
        companyCell.setAttribute("data-label", "Company Name");
        productCell.setAttribute("data-label", "Product Name");
        quantityCell.setAttribute("data-label", "Quantity");
        remarksCell.setAttribute("data-label", "Remarks");
        actionCell.setAttribute("data-label", "Action");

        let selectHTML = '<select name="product_id[]" class="form-control">';
        selectHTML += '<option value="">Select Product</option>';
        productOptions.forEach(function(product) {
            selectHTML += `<option value="${product.id}">${product.name}</option>`;
        });
        selectHTML += '</select>';

        serialCell.innerText = serialNumber++;
        companyCell.innerHTML = '<input type="text" placeholder="Enter company name" class="form-control">';
        // productCell.innerHTML = '<input type="text" placeholder="Enter products" class="form-control">';
        productCell.innerHTML = selectHTML;
        quantityCell.innerHTML = '<input type="number" placeholder="Enter quantity" class="form-control">';
        remarksCell.innerHTML = '<input type="text" placeholder="Enter remarks" class="form-control">';
        actionCell.innerHTML = '<button onclick="deletefirmRow(this)" class="btn btn-primary">Delete</button>';
    }

    function deletefirmRow(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        serialNumber--;
        updatefirmSerialNumbers();
    }

    function updatefirmSerialNumbers() {
        let table = document.getElementById("firmdataTable").getElementsByTagName('tbody')[0];
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[0].innerText = i + 1;
        }
    }
</script> --}}
<script>
    // Pass product data from Blade to JS (convert to JSON for safe use)
    const productOptions = @json($products);

    let firmRowCount = 1;

    $(document).ready(function() {
        $(document).on('click', '#addNewFirmRow', function() {
            firmRowCount++;

            let newRow = `
                <tr>
                    <td data-label="S.No.">${firmRowCount}</td>
                    <td data-label="Company Name">
                        <input type="text" name="company_name[]" class="form-control" placeholder="Enter company name">
                    </td>
                    <td data-label="Products">
                        <select name="product_id[]" class="form-control">
                            <option value="">Select Product</option>
                            ${productOptions.map(product => `<option value="${product.id}">${product.product_name}</option>`).join('')}
                        </select>
                    </td>
                    <td data-label="Quantity">
                        <input type="number" name="quantity[]" class="form-control" placeholder="Enter quantity">
                    </td>
                    <td data-label="Remarks">
                        <input type="text" name="remarks[]" class="form-control" placeholder="Enter remarks">
                    </td>
                    <td data-label="Action">
                        <button type="button" class="btn btn-danger deleteFirmRow">Delete</button>
                    </td>
                </tr>`;

            $('#firmdataTable tbody').append(newRow);
            updateFirmSerialNumbers();
        });

        // Delete row
        $(document).on('click', '.deleteFirmRow', function() {
            $(this).closest('tr').remove();
            firmRowCount--;
            updateFirmSerialNumbers();
        });

        // Update serial numbers after adding/removing rows
        function updateFirmSerialNumbers() {
            $('#firmdataTable tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }
    });
</script>



{{-- <script>
    function addpropRow() {
        let table = document.getElementById("propertiesdataTable").getElementsByTagName('tbody')[0];
        let rowCount = table.rows.length; // Get the number of existing rows
        let newRow = table.insertRow();

        // Insert new cells
        let serialCell = newRow.insertCell(0);
        let nameCell = newRow.insertCell(1);
        let dobCell = newRow.insertCell(2);
        let addressCell = newRow.insertCell(3);

        // let fatherHusbandCell = newRow.insertCell(3);
        // let maritalCell = newRow.insertCell(4);
        let actionCell = newRow.insertCell(4);

        // Add data-label attributes
        serialCell.setAttribute("data-label", "S.No.");
        nameCell.setAttribute("data-label", "Name");
        dobCell.setAttribute("data-label", "Date of Birth");
        addressCell.setAttribute("data-label", "Address");
        // fatherHusbandCell.setAttribute("data-label", "Father’s/Husband’s Name");
        // maritalCell.setAttribute("data-label", "Marital Status");
        actionCell.setAttribute("data-label", "Action");

        // Populate the new cells
        serialCell.innerText = rowCount + 1;
        nameCell.innerHTML = '<input type="text" placeholder="Enter name" class="form-control">';
        dobCell.innerHTML = `
         <div class="icon-form">
             <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
             <input type="text" class="form-control datetimepicker" placeholder="">
         </div>`;
        addressCell.innerHTML = '<textarea placeholder="Enter Address" class="form-control"></textarea>';
        // fatherHusbandCell.innerHTML =
        //     '<input type="text" placeholder="Enter father’s/husband’s name" class="form-control">';
        // maritalCell.innerHTML = '<select class="form-control"><option>Single</option><option>Married</option></select>';
        actionCell.innerHTML =
            '<button type="button" class="btn btn-danger" onclick="deletepropRow(this)">Delete</button>';
    }

    function deletepropRow(button) {
        let row = button.closest("tr");
        row.parentNode.removeChild(row);
        updatepropSerialNumbers();
    }

    function updatepropSerialNumbers() {
        let table = document.getElementById("propertiesdataTable").getElementsByTagName('tbody')[0];
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[0].innerText = i + 1;
        }
    }
</script> --}}

<script>
    let propRowCount = 1;

    $(document).ready(function() {
        // Initialize datetimepicker on existing inputs (use your own plugin init if needed)
        $('.datetimepicker').datepicker?.({
            dateFormat: 'yy-mm-dd'
        });

        // Add new row
        $('#addNewPropRow').on('click', function() {
            propRowCount++;

            let newRow = `
                <tr>
                    <td data-label="S.No.">${propRowCount}</td>
                    <td data-label="Name">
                        <input type="text" placeholder="Enter name" class="form-control">
                    </td>
                    <td data-label="Date of Birth" class="dateofbirth">
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" class="form-control datetimepicker" placeholder="">
                        </div>
                    </td>
                    <td data-label="Address">
                        <textarea placeholder="Enter Address" class="form-control"></textarea>
                    </td>
                    <td data-label="Action">
                        <button type="button" class="btn btn-danger deletePropRow">Delete</button>
                    </td>
                </tr>`;

            $('#propertiesdataTable tbody').append(newRow);
            updatePropSerialNumbers();

            // Re-initialize datetimepicker for new input
            $('.datetimepicker').datepicker?.({
                dateFormat: 'yy-mm-dd'
            });
        });

        // Delete row
        $(document).on('click', '.deletePropRow', function() {
            $(this).closest('tr').remove();
            propRowCount--;
            updatePropSerialNumbers();
        });

        // Update serial numbers
        function updatePropSerialNumbers() {
            $('#propertiesdataTable tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }
    });
</script>


{{--
<script>
    $(document).ready(function() {
        $("#userForm").validate({
            rules: {
                app_form_no: {
                    required: true
                },
                code_no: {
                    required: true
                },
                applicant_name: {
                    required: true
                },
                firm_shop_name: {
                    required: true
                },
                firm_shop_address: {
                    required: true
                },
                mobile_no: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                pancard: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                gstin: {
                    required: true
                },
                aadhar_card: {
                    required: true,
                    digits: true,
                    minlength: 12,
                    maxlength: 12
                }
            },
            messages: {
                app_form_no: "Please enter the application form number",
                code_no: "Please enter the code number",
                applicant_name: "Please enter applicant's name",
                firm_shop_name: "Please enter firm/shop name",
                firm_shop_address: "Please enter firm/shop address",
                mobile_no: {
                    required: "Please enter mobile number",
                    digits: "Only numbers are allowed",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must be 10 digits"
                },
                pancard: {
                    required: "Please enter PAN card number",
                    minlength: "PAN must be 10 characters",
                    maxlength: "PAN must be 10 characters"
                },
                gstin: "Please enter GSTIN",
                aadhar_card: {
                    required: "Please enter Aadhar number",
                    digits: "Only numbers are allowed",
                    minlength: "Aadhar must be 12 digits",
                    maxlength: "Aadhar must be 12 digits"
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger'
        });
    });
</script> --}}
@endsection
