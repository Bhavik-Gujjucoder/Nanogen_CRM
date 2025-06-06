@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card des-deler-form">
    <div class="card-body">
        <form id="userForm" action="{{ route('distributors_dealers.update', $distributor_dealers->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="edit-distributorsform">
                <!-- Basic Info -->
                <div class="applicationdtl delerbox-border-b">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    <img id="profilePreview"
                                        src="{{ $distributor_dealers && $distributor_dealers->profile_image
                                            ? asset('storage/distributor_dealer_profile_image/' . $distributor_dealers->profile_image)
                                            : asset('images/default-user.png') }}"
                                        alt="Profile Image" class="img-thumbnail mb-2">
                                </div>
                                <div class="upload-content">
                                    <div class="upload-btn">
                                        <input name="profile_image" type="file" accept=".jpg,.jpeg,.gif,.png"
                                            onchange="previewProfilePicture(event)">
                                        <span>
                                            <i class="ti ti-file-broken"></i>Upload Profile Picture
                                        </span>
                                    </div>
                                    <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="radio-group-bg">
                            <div class="radio-group-flex">
                                @can('Distributors')
                                    <div class="radio-group-tab">
                                        <input type="radio" name="user_type" value="1"
                                            {{ old('user_type', $distributor_dealers->user_type) == '1' ? 'checked' : '' }}
                                            id="distributor-radio" class="create-deitr" />
                                        <label for="distributor-radio">Distributor</label>
                                    </div>
                                @endcan
                                @can('Dealers')
                                    <div class="radio-group-tab">
                                        <input type="radio" name="user_type" value="2"
                                            {{ old('user_type', $distributor_dealers->user_type) == '2' ? 'checked' : '' }}
                                            id="dealers-radio" class="create-deitr" />
                                        <label for="dealers-radio">Dealers</label>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label"> Application Form No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="app_form_no"
                                    value="{{ old('app_form_no', $distributor_dealers->app_form_no) }}"
                                    class="form-control" placeholder="Application Form No" maxlength="255">
                                <span id="app_form_no_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Code No <span class="text-danger">*</span></label>
                                <input type="text" name="code_no" maxlength="255"
                                    value="{{ old('code_no', $distributor_dealers->code_no) }}" class="form-control"
                                    placeholder="Code No">
                                <span id="code_no_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Name of the Applicant <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="applicant_name"
                                    value="{{ old('applicant_name', $distributor_dealers->applicant_name) }}"
                                    class="form-control" placeholder="Name of the Applicant" maxlength="255">
                                <span id="applicant_name_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label"> Name of the Firm/Shop <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="firm_shop_name"
                                    value="{{ old('firm_shop_name', $distributor_dealers->firm_shop_name) }}"
                                    class="form-control" placeholder="Name of the Firm/Shop" maxlength="255">
                                <span id="firm_shop_name_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Address of the Firm/Shop <span
                                        class="text-danger">*</span></label>
                                <textarea name="firm_shop_address" class="form-control" placeholder="Address of the Firm/Shop">{{ old('firm_shop_address', $distributor_dealers->firm_shop_address) }}</textarea>
                                <span id="firm_shop_address_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Mobile No <span class="text-danger">*</span></label>
                                <input type="number" name="mobile_no"
                                    value="{{ old('mobile_no', $distributor_dealers->mobile_no) }}"
                                    class="form-control" placeholder="Mobile No"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                <span id="mobile_no_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Pan Card No <span class="text-danger">*</span></label>
                                <input type="text" name="pancard"
                                    value="{{ old('pancard', $distributor_dealers->pancard) }}" class="form-control"
                                    placeholder="Pan Card No" oninput="this.value = this.value.toUpperCase()"
                                    maxlength="10">
                                <span id="pancard_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">GSTIN <span class="text-danger">*</span></label>
                                <input type="text" name="gstin"
                                    value="{{ old('gstin', $distributor_dealers->gstin) }}" class="form-control"
                                    placeholder="GSTIN" oninput="this.value = this.value.toUpperCase()"
                                    maxlength="15">
                                <span id="gstin_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Aadhar Card No <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="aadhar_card"
                                    value="{{ old('aadhar_card', $distributor_dealers->aadhar_card) }}"
                                    class="form-control" placeholder="Aadhar Card No"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);">
                                <span id="aadhar_card_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="dealerlist">
                        <label class="col-form-label mright">Are you a registered dealer? <span
                                class="text-danger">*</span></label>
                        <ul class="d-flex">
                            <li class="form-check form-check-md d-flex align-items-center">
                                <input class="form-check-input" type="radio" name="registered_dealer"
                                    id="dealerYes" value="yes"
                                    {{ old('registered_dealer', $distributor_dealers->registered_dealer) == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dealerYes">Yes</label>
                            </li>
                            <li class="form-check form-check-md d-flex align-items-center">
                                <input class="form-check-input" type="radio" name="registered_dealer"
                                    id="dealerNo" value="no"
                                    {{ old('registered_dealer', $distributor_dealers->registered_dealer) == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dealerNo">No</label>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">State/Province <span
                                        class="text-danger">*</span></label>
                                <select id="stateDropdown" class="form-control " name="state_id">
                                    <option value="">Select state</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state_id', $distributor_dealers->state_id) == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="state_id_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">City <span class="text-danger">*</span></label>
                                <select id="cityDropdown" class="form-control " name="city_id">
                                    <option value="">Select city</option>
                                </select>
                                <span id="city_id_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" name="postal_code"
                                    value="{{ old('postal_code', $distributor_dealers->postal_code) }}"
                                    class="form-control " placeholder="Postal/Zip code">
                                <span id="postal_code_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Country <span class="text-danger">*</span></label>
                            <select id="inputState" class="form-control " name="country_id">
                                <option value="">Select country</option>
                                @foreach ($countries as $county)
                                    <option value="{{ $county->id }}"
                                        {{ old('country_id', $distributor_dealers->country_id) == $county->id ? 'selected' : '' }}>
                                        {{ $county->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="country_id_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="applicationdtl delerbox-border-b">
                    <h5 class="mb-2">Details of Bank A/c.</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Name and Address of Bank <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="bank_name_address"
                                    value="{{ old('bank_name_address', $distributor_dealers->bank_name_address) }}"
                                    class="form-control" placeholder="Name and Address of Bank" maxlength="255">
                                <span id="bank_name_address_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Account No <span class="text-danger">*</span></label>
                                <input type="number" name="account_no"
                                    value="{{ old('account_no', $distributor_dealers->account_no) }}"
                                    class="form-control" placeholder="Account No" maxlength="20">
                                <span id="account_no_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code"
                                    value="{{ old('ifsc_code', $distributor_dealers->ifsc_code) }}"
                                    class="form-control" placeholder="IFSC Code" maxlength="11">
                                <span id="ifsc_code_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Details of Security Cheque <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="security_cheque_detail"
                                    value="{{ old('security_cheque_detail', $distributor_dealers->security_cheque_detail) }}"
                                    class="form-control" placeholder="Details of Security Cheque" maxlength="255">
                                <span id="security_cheque_detail_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.1 </label>
                                <input type="number" name="cheque_1"
                                    value="{{ old('cheque_1', $distributor_dealers->cheque_1) }}"
                                    class="form-control" placeholder="Cheque No.1" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.2 </label>
                                <input type="number" name="cheque_2"
                                    value="{{ old('cheque_2', $distributor_dealers->cheque_2) }}"
                                    class="form-control" placeholder="Cheque No.2" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.3 </label>
                                <input type="number" name="cheque_3"
                                    value="{{ old('cheque_3', $distributor_dealers->cheque_3) }}"
                                    class="form-control" placeholder="Cheque No.3" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Name of Authorised Signatory <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name_authorised_signatory"
                                    value="{{ old('name_authorised_signatory', $distributor_dealers->name_authorised_signatory) }}"
                                    class="form-control" placeholder="Name of Authorised Signatory" maxlength="255">
                                <span id="name_authorised_signatory_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="listcheck mb-3">
                                <label class="col-form-label">Type of A/c. </label>
                                <ul>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="ac_type" type="radio" value="1"
                                            {{ old('ac_type', $distributor_dealers->ac_type) == '1' ? 'checked' : '' }}
                                            id="savings" checked>
                                        <label class="form-check-label" for="savings">Savings</label>
                                    </li>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="ac_type" type="radio" value="2"
                                            {{ old('ac_type', $distributor_dealers->ac_type) == '2' ? 'checked' : '' }}
                                            id="current">
                                        <label class="form-check-label" for="current">Current</label>
                                    </li>
                                    <li class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" name="ac_type" type="radio" value="3"
                                            {{ old('ac_type', $distributor_dealers->ac_type) == '3' ? 'checked' : '' }}
                                            id="other">
                                        <label class="form-check-label" for="other">Other (Please specify)</label>
                                    </li>
                                </ul>
                            </div>


                            <!-- Hidden input field for "Other" option -->
                            <div id="otherInputField" style="display: none; margin-top: 10px;">
                                <label class="form-check-label" for="other">Please Specify Other Account Type <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="other_ac_type"
                                    value="{{ old('other_ac_type', $distributor_dealers->other_ac_type) }}"
                                    class="form-control" placeholder="Please Specify Other Account Type">
                                <span id="other_ac_type_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 row">
                        <div class="col-md-4 ">
                            <div class="mb-3">
                                <label class="col-form-label">Fertilizer License No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="fertilizer_license"
                                    value="{{ old('fertilizer_license', $distributor_dealers->fertilizer_license) }}"
                                    class="form-control" placeholder="Fertilizer License No" maxlength="255">
                                <span id="fertilizer_license_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Pesticide License No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="pesticide_license"
                                    value="{{ old('pesticide_license', $distributor_dealers->pesticide_license) }}"
                                    class="form-control" placeholder="Pesticide License No" maxlength="255">
                                <span id="pesticide_license_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Seed License No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="seed_license"
                                    value="{{ old('seed_license', $distributor_dealers->seed_license) }}"
                                    class="form-control" placeholder="Seed License No" maxlength="255">
                                <span id="seed_license_error" class="text-danger"></span>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="applicationdtl delerbox-border-b">
                    <div class="d-flex">
                        <h5 class="mb-3">Name of firm/company under which dealership exist :</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-view addnewfield" id="dealership_companies">
                                    <thead>
                                        <tr>
                                            <th scope="col">S. No</th>
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Products</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Remarks</th>
                                            {{-- <th scope="col">Action</th> --}}
                                            <th scope="col">
                                                <button type="button" id="addNewFirmRow" class="btn btn-primary">Add
                                                    New</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($distributor_dealers->dealership_companies->isEmpty())
                                            <tr>
                                                <td data-label="S.No.">1</td>
                                                <td data-label="Company Name">
                                                    <input type="text" name="company_name[]" value=""
                                                        class="form-control" placeholder="Enter company name">
                                                </td>
                                                <td data-label="Products">
                                                    <select name="product_id[]" class="form-control">
                                                        <option value="">Select product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td data-label="Quantity">
                                                    <input type="number" name="quantity[]" value=""
                                                        class="form-control" placeholder="Enter quantity">
                                                </td>
                                                <td data-label="Remarks">
                                                    <input type="text" name="company_remarks[]" value=""
                                                        class="form-control" placeholder="Enter remarks">
                                                </td>
                                                <td data-label="Action">
                                                    {{-- <button type="button" id="addNewFirmRow"
                                                        class="btn btn-primary">Add
                                                        New</button> --}}
                                                        <button type="button"
                                                            class="btn btn-danger deleteFirmRow">Delete</button>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($distributor_dealers->dealership_companies as $c)
                                                <tr>
                                                    <td data-label="S.No.">{{ $loop->iteration }}</td>
                                                    <td data-label="Company Name">
                                                        <input type="text" name="company_name[]"
                                                            value="{{ old('company_name', $c->company_name) }}"
                                                            class="form-control" placeholder="Enter company name"
                                                            maxlength="255">
                                                    </td>
                                                    <td data-label="Products">
                                                        <select name="product_id[]" class="form-control">
                                                            <option value="">Select product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                    {{ $product->id == $c->product_id ? 'selected' : '' }}>
                                                                    {{ $product->product_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td data-label="Quantity">
                                                        <input type="number" name="quantity[]"
                                                            value="{{ old('quantity', $c->quantity) }}"
                                                            class="form-control" placeholder="Enter quantity">
                                                    </td>
                                                    <td data-label="Remarks">
                                                        <input type="text" name="company_remarks[]"
                                                            value="{{ old('company_remarks', $c->company_remarks) }}"
                                                            class="form-control" placeholder="Enter remarks">
                                                    </td>
                                                    <td data-label="Action">
                                                        <button type="button"
                                                            class="btn btn-danger deleteFirmRow">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="listcheck">
                                <label class="col-form-label">Status of Firm
                                </label>
                                <p class="smallnote">
                                    (For partnership firms enclose copy of partnership Deed
                                    and for Companies Memorandum Articles of Association)
                                </p>
                                <ul>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="1"
                                            {{ old('firm_status', $distributor_dealers->firm_status) == '1' ? 'checked' : '' }}
                                            id="proprietorship" checked>
                                        <label class="form-check-label" for="proprietorship">Proprietorship</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="2"
                                            {{ old('firm_status', $distributor_dealers->firm_status) == '2' ? 'checked' : '' }}
                                            id="partnership">
                                        <label class="form-check-label" for="partnership">Partnership</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="3"
                                            {{ old('firm_status', $distributor_dealers->firm_status) == '3' ? 'checked' : '' }}
                                            id="limitedcompany">
                                        <label class="form-check-label" for="limitedcompany">Limited Company</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="firm_status"
                                            value="4"
                                            {{ old('firm_status', $distributor_dealers->firm_status) == '4' ? 'checked' : '' }}
                                            id="private">
                                        <label class="form-check-label" for="private">Private Ltd. Co.</label>
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>


                <div class="applicationdtl delerbox-border-b">
                    <div class="row">


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
                                            {{-- <th scope="col">Action</th> --}}
                                            <th scope="col">
                                                <button type="button" id="addNewPropRow" class="btn btn-primary">Add New</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($distributor_dealers->proprietor_partner_director->isEmpty())
                                            <tr>
                                                <td data-label="S.No.">1</td>
                                                <td data-label="Name">
                                                    <input type="text" name="name[]" value="{{ old('name') }}"
                                                        placeholder="Enter name" class="form-control">
                                                </td>
                                                <td data-label="Date of Birth" class="dateofbirth">
                                                    <div class="icon-form">
                                                        <span class="form-icon"><i
                                                                class="ti ti-calendar-check"></i></span>
                                                        <input type="text" name="birthdate[]"
                                                            value="{{ old('birthdate') }}"
                                                            class="form-control datePicker" placeholder="">
                                                    </div>
                                                </td>
                                                <td data-label="Address">
                                                    <textarea name="address[]" placeholder="Enter address" class="form-control">{{ old('address') }}</textarea>
                                                </td>
                                                <td>
                                                    <button type="button" id="addNewPropRow" class="btn btn-primary">Add
                                                        New</button>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($distributor_dealers->proprietor_partner_director as $p)
                                                <tr>
                                                    <td data-label="S.No.">{{ $loop->iteration }}</td>
                                                    <td data-label="Name">
                                                        <input type="text" name="name[]"
                                                            value="{{ old('name', $p->name) }}" placeholder="Enter name"
                                                            class="form-control" maxlength="255">
                                                    </td>
                                                    <td data-label="Date of Birth" class="dateofbirth">
                                                        <div class="icon-form">
                                                            <span class="form-icon"><i
                                                                    class="ti ti-calendar-check"></i></span>
                                                            <input type="text" name="birthdate[]" {{-- value="{{ old('birthdate',$p->birthdate) }}" --}}
                                                                value="{{ old('birthdate', \Carbon\Carbon::parse($p->birthdate)->format('d-m-Y')) }}"
                                                                class="form-control datePicker" placeholder="">
                                                        </div>
                                                    </td>
                                                    <td data-label="Address">
                                                        <textarea name="address[]" placeholder="Enter address" class="form-control">{{ old('address', $p->address) }}</textarea>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-danger deletePropRow">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Name and address of associate firm(s) </label>
                                <input type="text" name="associate_name_address"
                                    value="{{ old('associate_name_address', $distributor_dealers->associate_name_address) }}"
                                    class="form-control" placeholder="Name and address of associate firm(s)"
                                    maxlength="255">
                                <span id="associate_name_address_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Indicate number of people employed in your firm
                                    (including active partners)</label>
                                <input type="number" name="indicate_number"
                                    value="{{ old('indicate_number', $distributor_dealers->indicate_number) }}"
                                    class="form-control"
                                    placeholder="Indicate number of people employed in your firm">
                                <span id="indicate_number_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="appthreeyear-sec">
                        <label class="col-form-label mb-1">Last three years turnover of your firm (in Rs.
                            Lacs/Cores)</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="turnover1"
                                        value="{{ old('turnover1', $distributor_dealers->turnover1) }}"
                                        placeholder="1st year turnover" maxlength="255">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="turnover2"
                                        value="{{ old('turnover2', $distributor_dealers->turnover2) }}"
                                        placeholder="2nd year turnover" maxlength="255">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="turnover3"
                                        value="{{ old('turnover3', $distributor_dealers->turnover3) }}"
                                        placeholder="3rd year turnover" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="listcheck mb-3">
                                    <label class="col-form-label">Do you have Godown Facility? </label>
                                    <ul>
                                        <li class="form-check form-check-md d-flex align-items-center">
                                            {{-- <input class="form-check-input" name="godown_facility" type="radio"
                                                value="yes" {{ old('godown_facility',$distributor_dealers->godown_facility) == 'yes' ? 'checked' : '' }}
                                                id="godown_yes"> --}}
                                            <input class="form-check-input" name="godown_facility" type="radio"
                                                value="yes"
                                                {{ trim(strtolower(old('godown_facility', $distributor_dealers->godown_facility))) == 'yes' ? 'checked' : '' }}
                                                id="godown_yes">

                                            <label class="form-check-label" for="godown_yes">Yes</label>
                                        </li>
                                        <li class="form-check form-check-md d-flex align-items-center">
                                            {{-- <input class="form-check-input" name="godown_facility" type="radio"
                                                value="no"
                                                {{ old('godown_facility', $distributor_dealers->godown_facility) == 'no' ? 'checked' : '' }}
                                                id="godown_no" checked> --}}
                                            <input class="form-check-input" name="godown_facility" type="radio"
                                                value="no"
                                                {{ trim(strtolower(old('godown_facility', $distributor_dealers->godown_facility))) == 'no' ? 'checked' : '' }}
                                                id="godown_no">
                                            <label class="form-check-label" for="godown_no">No</label>
                                        </li>
                                    </ul>
                                </div>
                                <div id="godownSizeField" style="display: none; margin-top: 10px;">
                                    <div class="row">
                                        <div class="col-md-6 mt-0">
                                            <div class="mb-3">
                                                <label class="col-form-label">Indicate Size and Capacity of
                                                    Godown</label>
                                                <input type="text" name="godown_size_capacity"
                                                    value="{{ old('godown_size_capacity', $distributor_dealers->godown_size_capacity) }}"
                                                    class="form-control"
                                                    placeholder="Indicate Size and Capacity of Godown"
                                                    maxlength="255">
                                                <span id="godown_size_capacity_error" class="text-danger"></span>
                                            </div>
                                        </div>


                                        <div class="col-md-6 mt-0">
                                            <div class="mb-3">
                                                <label class="col-form-label">Address of Godown</label>
                                                <textarea type="text" name="godown_address" class="form-control" placeholder="Address of Godown">{{ old('godown_address', $distributor_dealers->godown_address) }}</textarea>
                                                <span id="godown_address_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Expected Minimum Sales</label>
                                <input type="text" name="expected_minimum_sales" class="form-control"
                                    placeholder="Expected Minimum Sales"
                                    value="{{ old('expected_minimum_sales', $distributor_dealers->expected_minimum_sales) }}"
                                    maxlength="255">
                                <span id="expected_minimum_sales_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Place</label>
                                <input type="text" name="place" class="form-control" placeholder="Place"
                                    value="{{ old('place', $distributor_dealers->place) }}" maxlength="255">
                                <span id="place_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label">Date</label>
                                <input type="text" name="date" class="form-control datePicker"
                                    placeholder="Date" {{-- value="{{ old('date',$distributor_dealers->date) }}"> --}} {{-- value="{{ old('date', isset($distributor_dealers) ? \Carbon\Carbon::parse($distributor_dealers->date)->format('d-m-Y') : '') }}"> --}}
                                    value="{{ old('date', \Carbon\Carbon::parse($distributor_dealers->date)->format('d-m-Y')) }}">
                                <span id="date_error" class="text-danger"></span>
                            </div>
                        </div>


                    </div>


                </div>

                <div class="applicationdtl delerbox-border-b">




                    <div class="applicationdtl mb-3">
                        <h5 class="mb-2">FOR OFFICE USE ONLY</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Location of business/premises</label>
                                    <input type="text" name="business_location"
                                        value="{{ old('business_location', $distributor_dealers->business_location) }}"
                                        class="form-control" placeholder="Name and Address of Bank" maxlength="255">
                                    <span id="business_premises_location_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                        <div class="applicationdtl mb-3">
                            {{-- <h5 class="mb-3">Last three years turnover of your firm (in Rs. Lacs/Cores)</h5> --}}
                            <label class="col-form-label mb-1">Godown capacity</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="col-form-label">Area in sq. fee</label>
                                        <input type="text" class="form-control" name="godown_capacity_area"
                                            value="{{ old('godown_capacity_area', $distributor_dealers->godown_capacity_area) }}"
                                            placeholder="Area in sq. fee" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="col-form-label">Capacity in bags</label>
                                        <input type="text" class="form-control" name="godown_capacity_inbags"
                                            value="{{ old('godown_capacity_inbags', $distributor_dealers->godown_capacity_inbags) }}"
                                            placeholder="Capacity in bags" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="col-form-label d-block">Construction</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="godown_construction"
                                                id="construction_permanent" value="Permanent"
                                                {{ old('godown_construction', $distributor_dealers->godown_construction) == 'Permanent' ? 'checked' : '' }}
                                                checked>
                                            <label class="form-check-label"
                                                for="construction_permanent">Permanent</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="godown_construction"
                                                id="construction_temporary" value="Temporary"
                                                {{ old('godown_construction', $distributor_dealers->godown_construction) == 'Temporary' ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="construction_temporary">Temporary</label>
                                        </div>
                                        <br>
                                        <span id="construction_error" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="col-form-label">Experience and capability </label>
                                        <input type="text" name="experience_capability" class="form-control"
                                            value="{{ old('experience_capability', $distributor_dealers->experience_capability) }}"
                                            placeholder="Experience and capability" maxlength="255">
                                        <span id="experience_capability_error" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="col-form-label">Financial standing and capability to invest
                                        </label>
                                        <input type="text" name="financial_capability" class="form-control"
                                            value="{{ old('financial_capability', $distributor_dealers->financial_capability) }}"
                                            placeholder="Financial standing and capability to invest" maxlength="255">
                                        <span id="financial_capability_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label d-block">Market reputation and credibility </label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="market_reputation"
                                        id="excellent" value="Excellent"
                                        {{ old('market_reputation', $distributor_dealers->market_reputation) == 'Excellent' ? 'checked' : '' }}
                                        checked>
                                    <label class="form-check-label" for="excellent">Excellent</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="market_reputation"
                                        id="very_good" value="Very Good"
                                        {{ old('market_reputation', $distributor_dealers->market_reputation) == 'Very Good' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="very_good">Very Good</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="market_reputation"
                                        id="good" value="Good"
                                        {{ old('market_reputation', $distributor_dealers->market_reputation) == 'Good' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="good">Good</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="market_reputation"
                                        id="average" value="Average"
                                        {{ old('market_reputation', $distributor_dealers->market_reputation) == 'Average' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="average">Average</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="market_reputation"
                                        id="poor" value="Poor"
                                        {{ old('market_reputation', $distributor_dealers->market_reputation) == 'Poor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="poor">Poor</label>
                                </div>

                                <br>
                                <span id="market_reputation_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Business potential of party (Estimated
                                        sales/month) </label>
                                    <input type="text" name="business_potential" class="form-control"
                                        placeholder="Estimated sales/month"
                                        value="{{ old('business_potential', $distributor_dealers->market_potential) }}"
                                        maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Total market potential of the area </label>
                                    <input type="text" name="market_potential" class="form-control"
                                        placeholder="Total market potential"
                                        value="{{ old('market_potential', $distributor_dealers->market_potential) }}"
                                        maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Assurance of minimum turnover</label>
                                    <input type="text" name="minimum_turnover" class="form-control"
                                        placeholder="Minimum turnover assurance"
                                        value="{{ old('minimum_turnover', $distributor_dealers->minimum_turnover) }}"
                                        maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Approximate number of competitors stockists in
                                        the area/town (major competitors) </label>
                                    <input type="text" name="competitor_count" class="form-control"
                                        placeholder="No. of major competitors"
                                        value="{{ old('competitor_count', $distributor_dealers->competitor_count) }}"
                                        maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Credit limit </label>
                                    <input type="text" name="cr_limit" class="form-control"
                                        placeholder="Cr limit"
                                        value="{{ old('cr_limit', $distributor_dealers->cr_limit) }}"
                                        maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-5 mb-3">
                                <label class="col-form-label">Payment Reminder</label> {{-- Credit Limit --}}
                                <div class="form-input-icon input-group gropinginput box-bordernone">
                                    <input type="number" step="any" class="form-control" placeholder="0"
                                        name="credit_limit"
                                        value="{{ old('credit_limit', $distributor_dealers->credit_limit) }}">
                                    <div class="form-input-icon select-2-box">
                                        <select class="select2" id="credit_limit_type" name="credit_limit_type"
                                            aria-hidden="true" style="width:100%">
                                            <option value="day"
                                                {{ old('credit_limit_type', $distributor_dealers->credit_limit_type) == 'day' ? 'selected' : '' }}>
                                                Days</option>
                                            <option value="month"
                                                {{ old('credit_limit_type', $distributor_dealers->credit_limit_type) == 'month' ? 'selected' : '' }}>
                                                Month</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="col-form-label">Remarks (if any)</label>
                                    <textarea name="remarks" class="form-control del-form-textarea" rows="3"
                                        placeholder="Enter any remarks here...">{{ old('remarks', $distributor_dealers->remarks) }}</textarea>
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label fw-bold">Uploaded Documents:</label>
                                <div class="border p-3 rounded bg-light">
                                    @if ($distributor_dealers->documents->count())
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($distributor_dealers->documents as $document)
                                                @php
                                                    $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));
                                                    $fileUrl = asset('storage/' . $document->file_path);
                            
                                                    // Define download-only types
                                                    $downloadTypes = ['doc', 'docx'];
                            
                                                    // Define icon (optional)
                                                    $icon = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']) ? 'bi-image' :
                                                            ($extension === 'pdf' ? 'bi-file-earmark-pdf' :
                                                            (in_array($extension, ['xls', 'xlsx']) ? 'bi-file-earmark-excel' : 'bi-file-earmark'));
                                                @endphp
                            
                                                <li class="mb-1">
                                                    @if (in_array($extension, $downloadTypes))
                                                        <a href="{{ $fileUrl }}" download="{{ $document->file_name }}" class="text-success">
                                                            <i class="bi {{ $icon }} me-1"></i>
                                                            {{ $document->file_name }}
                                                        </a>
                                                    @else
                                                        <a href="{{ $fileUrl }}" target="_blank" class="text-primary">
                                                            <i class="bi {{ $icon }} me-1"></i>
                                                            {{ $document->file_name }}
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">No documents uploaded.</p>
                                    @endif
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3">
                                <label class="form-label fw-bold">Uploaded Documents:</label>
                                <div class="border p-3 rounded bg-light">
                                    @if ($distributor_dealers->documents->count())
                                        <ul class="list-unstyled mb-0 row">
                                            @foreach ($distributor_dealers->documents as $document)
                                                @php
                                                    $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));
                                                    $fileUrl = asset('storage/' . $document->file_path);
                                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    $downloadTypes = ['doc', 'docx'];
                                                    $openInTab = !in_array($extension, $downloadTypes);
                                                    $icon = match($extension) {
                                                        'pdf' => 'bi-file-earmark-pdf',
                                                        'doc', 'docx' => 'bi-file-earmark-word',
                                                        'xls', 'xlsx' => 'bi-file-earmark-excel',
                                                        default => 'bi-file-earmark'
                                                    };
                                                @endphp
                            
                                                <li class="col-md-4 mb-3">
                                                    <div class="fw-semibold mb-1">{{ $loop->iteration }}.</div>
                                                    @if ($isImage)
                                                        <a href="{{ $fileUrl }}" target="_blank" class="d-block">
                                                            <img src="{{ $fileUrl }}" alt="{{ $document->file_name }}"
                                                                 class="img-thumbnail" style="max-height: 100px;">
                                                            <div class="mt-1 text-truncate">{{ $document->file_name }}</div>
                                                        </a>
                                                    @else
                                                        @if ($openInTab)
                                                            <a href="{{ $fileUrl }}" target="_blank" class="text-primary d-flex align-items-center">
                                                                <i class="bi {{ $icon }} fs-4 me-2"></i> {{ $document->file_name }}
                                                            </a>
                                                        @else
                                                            <a href="{{ $fileUrl }}" download="{{ $document->file_name }}" class="text-success d-flex align-items-center">
                                                                <i class="bi {{ $icon }} fs-4 me-2"></i> {{ $document->file_name }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">No documents uploaded.</p>
                                    @endif
                                </div>
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label fw-bold">Uploaded Documents:</label>
                                <div class="border p-3 rounded bg-light">
                                    @if ($distributor_dealers->documents->count())
                                        <div class="row gc-dd-document">
                                            @foreach ($distributor_dealers->documents as $document)
                                                @php
                                                    $extension = strtolower(
                                                        pathinfo($document->file_name, PATHINFO_EXTENSION),
                                                    );
                                                    $fileUrl = asset('storage/' . $document->file_path);
                                                    $isImage = in_array($extension, [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif',
                                                        'webp',
                                                    ]);
                                                    $downloadTypes = ['doc', 'docx'];
                                                    $openInTab = !in_array($extension, $downloadTypes);
                                                    $icon = match ($extension) {
                                                        'pdf' => 'bi-file-earmark-pdf',
                                                        'doc', 'docx' => 'bi-file-earmark-word',
                                                        'xls', 'xlsx' => 'bi-file-earmark-excel',
                                                        default => 'bi-file-earmark',
                                                    };
                                                @endphp

                                                <div class="col-md-4 col-sm-4 mb-3">
                                                    <div class="border rounded p-2 h-100 bg-white shadow-sm">
                                                        <div class="fw-semibold mb-2">{{ $loop->iteration }}.</div>

                                                        @if ($isImage)
                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                                class="d-block mb-2">
                                                                <img src="{{ $fileUrl }}"
                                                                    alt="{{ $document->file_name }}"
                                                                    class="img-thumbnail" style="max-height: 100px;">
                                                            </a>
                                                        @else
                                                            @if ($openInTab)
                                                                <a href="{{ $fileUrl }}" target="_blank"
                                                                    class="text-primary d-flex align-items-center mb-2">
                                                                    <i class="bi {{ $icon }} fs-4 me-2"></i>
                                                                    {{ $document->file_name }}
                                                                </a>
                                                            @else
                                                                <a href="{{ $fileUrl }}"
                                                                    download="{{ $document->file_name }}"
                                                                    class="text-success d-flex align-items-center mb-2">
                                                                    <i class="bi {{ $icon }} fs-4 me-2"></i>
                                                                    {{ $document->file_name }}
                                                                </a>
                                                            @endif
                                                        @endif

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger delete_document"
                                                            data-id="{{ $document->id }}"
                                                            data-url="{{ route('distributors_dealers.documents_destroy', $document->id) }}">
                                                            <i class="ti ti-trash text-white"></i> Delete
                                                        </button>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">No documents uploaded.</p>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label class="col-form-label">Add Documents <small class="text-muted"> (JPG, JPEG,
                                            PNG, GIF, WEBP, DOC or DOCX)</small></label>
                                </div>
                            </div>
                            <div id="fileUploadWrapper">
                                <div class="col-md-5 file-group">
                                    <div class="form-input-icon input-group gropinginput box-bordernone">
                                        <input type="file" name="files[]" class="form-control mb-1"
                                            accept=".jpg,.jpeg,.png,.gif,.webp,.doc,.docx" />
                                        <div class="form-input-icon">
                                            <button type="button"
                                                class="btn btn-danger removeFileBtn">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-input-icon mt-2">
                                <button type="button" id="addFileBtn" class="btn btn-primary">Add New File</button>
                            </div>



                        </div>

                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                {{-- <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a> --}}
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <!-- /Basic Info -->
        </form>
    </div>
</div>

@endsection
@section('script')
<script>
    /**** State wise city dropdown ****/
    $(document).ready(function() {
        const selectedStateId = '{{ $distributor_dealers->state_id }}';
        const selectedCityId = '{{ $distributor_dealers->city_id }}';

        // Load cities on page load
        if (selectedStateId) {
            loadCities(selectedStateId, selectedCityId);
        }

        // When user changes state
        $('#stateDropdown').on('change', function() {
            const stateId = $(this).val();
            loadCities(stateId, null); // reset selected city
        });

        function loadCities(stateId, selectedCityId) {
            $('#cityDropdown').html('<option value="">Loading...</option>');

            $.ajax({
                url: "{{ route('get.cities') }}",
                type: "POST",
                data: {
                    state_id: stateId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#cityDropdown').empty().append('<option value="">Select City</option>');
                    $.each(data, function(index, city) {
                        const selected = city.id == selectedCityId ? 'selected' : '';
                        $('#cityDropdown').append('<option value="' + city.id + '" ' +
                            selected + '>' + city.city_name + '</option>');
                    });
                }
            });
        }
    });

    /**** date-picker ****/
    function initFlatpickr() {
        $('.datePicker').each(function() {
            if (!$(this).hasClass('flatpickr-input')) {
                flatpickr(this, {
                    dateFormat: "d-m-Y", // CORRECTED format
                    disableMobile: true,
                    maxDate: "today",
                    onReady: removeTodayHighlight,
                    onMonthChange: removeTodayHighlight,
                    onYearChange: removeTodayHighlight,
                    onOpen: removeTodayHighlight,
                    onChange: removeTodayHighlight
                });
            }
        });
    }

    function removeTodayHighlight(selectedDates, dateStr, instance) {
        const todayElem = instance.calendarContainer.querySelector(".flatpickr-day.today");
        if (todayElem && !todayElem.classList.contains("selected")) {
            todayElem.classList.remove("today");
        }
    }
    // Call it once on page load
    initFlatpickr();

    /**** validation ****/
    $(document).ready(function() {
        $("#userForm").validate({
            rules: {
                app_form_no: "required",
                code_no: "required",
                applicant_name: "required",
                firm_shop_name: "required",
                firm_shop_address: "required",
                mobile_no: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                pancard: "required",
                gstin: "required",
                aadhar_card: {
                    required: true,
                    digits: true,
                    minlength: 12,
                    maxlength: 12
                },
                state_id: "required",
                city_id: "required",
                postal_code: "required",
                country_id: "required",

                bank_name_address: "required",
                account_no: "required",
                ifsc_code: "required",
                security_cheque_detail: "required",
                name_authorised_signatory: "required",
                fertilizer_license: "required",
                pesticide_license: "required",
                seed_license: "required",
                other_ac_type: {
                    required: function() {
                        return $("input[name='ac_type']:checked").val() == "3";
                    }
                }
            },
            messages: {
                app_form_no: "The application form No field is required.",
                code_no: "The code no field is required.",
                applicant_name: "The applicant name field is required.",
                firm_shop_name: "The firm/shop name field is required.",
                firm_shop_address: "The firm/shop address field is required.",
                mobile_no: {
                    required: "The mobile no field is required.",
                    digits: "Mobile number must be numeric.",
                    minlength: "Mobile number must be 10 digits.",
                    maxlength: "Mobile number must be 10 digits."
                },
                pancard: "The pan card No field is required.",
                gstin: "The gstin field is required.",
                aadhar_card: {
                    required: "The aadhar card no field is required.",
                    digits: "Aadhar card No must be numeric.",
                    minlength: "Aadhar card No must be 12 digits.",
                    maxlength: "Aadhar card No must be 12 digits."
                },
                state_id: "Please select a state.",
                city_id: "Please select a city.",
                postal_code: "Postal code is required.",
                country_id: "Please select a country.",

                bank_name_address: "The bank name and address field is required.",
                account_no: "The account no field is required.",
                ifsc_code: "The ifsc code field is required.",
                security_cheque_detail: "The security cheque details field is required.",
                name_authorised_signatory: "The name of authorised signatory field is required.",
                fertilizer_license: "The fertilizer license no field is required.",
                pesticide_license: "The pesticide license no field is required.",
                seed_license: "The seed license no field is required.",
                other_ac_type: "Please specify the other account type."
            },
            errorPlacement: function(error, element) {
                let id = element.attr("name") + "_error";
                $("#" + id).html(error);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            },
            invalidHandler: function(event, validator) {
                if (validator.errorList.length) {
                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top - 100
                    }, 600);
                    $(validator.errorList[0].element).focus();
                }
            }
        });
    });
    // Catch all: prevent native submit unless valid
    $("#userForm").on("submit", function(e) {
        if (!$(this).valid()) {
            e.preventDefault(); // Block submit if invalid
        }
    });
</script>


<!-- other account type field  -->
<script>
    $("input[name='ac_type']").on("change", function() {
        if ($(this).val() == "3") {
            $("#otherInputField").slideDown();
        } else {
            $("#otherInputField").slideUp();
            $("input[name='other_ac_type']").val(""); // Clear field when hiding
            $("#other_ac_type_error").html(""); // clear error if hidden
        }

    });
    // ✅ Check if "other_ac_type" has a value on page load
    if ($("input[name='ac_type']:checked").val() == "3" &&
        $("input[name='other_ac_type']").val().trim() !== "") {
        $("#otherInputField").show();
    }

    $("input[name='godown_facility']").on("change", function() {
        if ($(this).val() === "yes") {
            $("#godownSizeField").slideDown();
        } else {
            $("#godownSizeField").slideUp();
            $("input[name='godown_size_capacity']").val(""); // Clear field when hiding
            $("textarea[name='godown_address']").val("");
            $("#godown_size_capacity_error").html(""); // Clear error when hiding
        }
    });

    // ✅ Check on page load: if godown_facility is "yes" and value exists, show the field
    if ($("input[name='godown_facility']:checked").val() === "yes" &&
        $("input[name='godown_size_capacity']").val().trim() !== "") {
        $("#godownSizeField").show();
    }
</script>

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
                            <option value="">Select product</option>
                            ${productOptions.map(product => `<option value="${product.id}">${product.product_name}</option>`).join('')}
                        </select>
                    </td>
                    <td data-label="Quantity">
                        <input type="number" name="quantity[]" class="form-control" placeholder="Enter quantity">
                    </td>
                    <td data-label="Remarks">
                        <input type="text" name="company_remarks[]" class="form-control" placeholder="Enter remarks">
                    </td>
                    <td data-label="Action">
                        <button type="button" class="btn btn-danger deleteFirmRow">Delete</button>
                    </td>
                </tr>`;

            $('#dealership_companies tbody').prepend(newRow);
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
            $('#dealership_companies tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }
    });
</script>

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
                        <input type="text" name="name[]" value="{{ old('name') }}"  placeholder="Enter name" class="form-control">
                    </td>
                    <td data-label="Date of Birth" class="dateofbirth">
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text"  name="birthdate[]" value="{{ old('birthdate') }}" class="form-control datePicker" placeholder="">
                        </div>
                    </td>
                    <td data-label="Address">
                        <textarea placeholder="Enter address" name="address[]" class="form-control">{{ old('address') }}</textarea>
                    </td>
                    <td data-label="Action">
                        <button type="button" class="btn btn-danger deletePropRow">Delete</button>
                    </td>
                </tr>`;

            $('#propertiesdataTable tbody').prepend(newRow); //append
            updatePropSerialNumbers();

            /* Initialize Flatpickr for newly added row */
            initFlatpickr();
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

    function previewProfilePicture(event) {
        const file = event.target.files[0]; // Get the selected file
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target
                    .result; // Set image preview source
            }
            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    }


    /**** multy images add  ****/
    $(document).on('click', '#addFileBtn', function() {
        const newInput = `
            <div class="col-md-5 file-group mt-2">
                <div class="form-input-icon input-group gropinginput box-bordernone">
                    <input type="file" name="files[]" class="form-control mb-1" />
                    <div class="form-input-icon">
                        <button type="button" class="btn btn-danger removeFileBtn">Remove</button>
                    </div>
                </div>
            </div>
        `;
        $('#fileUploadWrapper').append(newInput);
    });

    // Remove file input
    $(document).on('click', '.removeFileBtn', function() {
        $(this).closest('.file-group').remove();
    });
    /***end***/

    /**** Documents Image delete ***/
    $(document).on('click', '.delete_document', function(event) {
        event.preventDefault();
        let button = $(this);
        let document_id = button.data('id');
        let url = button.data('url'); // URL from data attribute

        confirmDeletion(function() {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Optionally show toast/alert
                    Swal.fire('Deleted!', 'Document has been deleted.', 'success');
                    // Remove the card or reload list
                    button.closest('.col-md-4').remove();
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                }
            });
        });
    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this Document? Once deleted, it cannot be recovered.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'my-custom-popup',
                title: 'my-custom-title',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary',
                icon: 'my-custom-icon swal2-warning'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                callback(); // Execute callback function if confirmed
            }
        });
    }
</script>
@endsection
