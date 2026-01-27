@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
@php
    $activeTab = old('form_type', 'general-setting'); // fallback to first tab
@endphp
<div class="card">
    <div class="card-body">

        <!--ALL TABS-->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'general-setting' ? 'active' : '' }}" id="GeneralSetting"
                    data-bs-toggle="tab" href="#general-setting" role="tab" aria-controls="general-setting"
                    aria-selected="true{{-- $activeTab == 'general-setting' ? 'true' : 'false' --}}">General Setting</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'parent-category' ? 'active' : '' }}" id="ParentCategory"
                    data-bs-toggle="tab" href="#parent-category" role="tab" aria-controls="parent-category"
                    aria-selected="true{{-- $activeTab == 'parent-category' ? 'true' : 'false' --}}">Parent Category</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'company-detail' ? 'active' : '' }}" id="CompanyDetails"
                    data-bs-toggle="tab" href="#company-details" role="tab" aria-controls="company-details"
                    aria-selected="{{ $activeTab == 'company-detail' ? 'true' : 'false' }}">Company Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'email-detail' ? 'active' : '' }}" id="EmailDetails"
                    data-bs-toggle="tab" href="#email-detail" role="tab" aria-controls="email-detail"
                    aria-selected="{{ $activeTab == 'email-detail' ? 'true' : 'false' }}">Email Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'distributors-dealers' ? 'active' : '' }}" id="DistributorsDealers"
                    data-bs-toggle="tab" href="#Distributors-Dealers" role="tab"
                    aria-controls="Distributors-Dealers"
                    aria-selected="{{ $activeTab == 'distributors-dealers' ? 'true' : 'false' }}">Distributors and
                    Dealers</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'o_form' ? 'active' : '' }}" id="o_form_tab" data-bs-toggle="tab"
                    href="#o_form" role="tab" aria-controls="o_form" aria-selected="false">O Form</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'principal_certificate' ? 'active' : '' }}"
                    id="principal_certificate_tab" data-bs-toggle="tab" href="#principal_certificate" role="tab"
                    aria-controls="principal_certificate" aria-selected="false">Principal Certificate</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'advance-payment-discount' ? 'active' : '' }}"
                    id="AdvancePaymentDiscount" data-bs-toggle="tab" href="#Advance-Payment-Discount" role="tab"
                    aria-controls="Advance-Payment-Discount"
                    aria-selected="{{ $activeTab == 'advance-payment-discount' ? 'true' : 'false' }}">Advance Payment
                    Discount</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'pdf-price-list' ? 'active' : '' }}" id="PdfPriceList"
                    data-bs-toggle="tab" href="#Pdf-Price-List" role="tab" aria-controls="Pdf-Price-List"
                    aria-selected="{{ $activeTab == 'pdf-price-list' ? 'true' : 'false' }}">PDF Price List</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">

            <!--G E N E R A L   S E T T I N G   T A B-->
            <div class="tab-pane {{ $activeTab == 'general-setting' ? 'show active' : '' }}" id="general-setting"
                role="tabpanel" aria-labelledby="GeneralSetting">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="general-setting">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    @if (getSetting('login_page_image') && !empty(getSetting('login_page_image')))
                                        <img id="loginPagePreview"
                                            src="{{ getSetting('login_page_image') ? asset('storage/login_page_image/' . getSetting('login_page_image')) : asset('images/default-user.png') }} "
                                            alt="Profile Picture"class="img-thumbnail mb-2" width="96.36px"
                                            height="100px" style="object-fit: contain" alt="Profile Picture">
                                    @endif
                                </div>

                                <div class="upload-content">
                                    <div class="upload-btn  @error('login_page_image') is-invalid @enderror">
                                        <input type="file" name="login_page_image" accept=".jpg,.jpeg,.gif,.png"
                                            onchange="previewProfilePicture(event, 'loginPagePreview')">
                                        <span>
                                            <i class="ti ti-file-broken"></i>Login Page Image
                                        </span>
                                    </div>
                                    <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                    @error('login_page_image')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Copyright Message<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('copyright_msg') is-invalid @enderror" name="copyright_msg"
                                    placeholder="Copyright Message">{{ old('copyright_msg', getSetting('copyright_msg')) }}</textarea>
                                @error('copyright_msg')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

            <!--P A R E N T  C A T E G O R Y   T A B-->
            <div class="tab-pane fade  {{-- $activeTab == 'parent-category' ? 'show active' : '' --}}" id="parent-category" role="tabpanel"
                aria-labelledby="parent-category">

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-left">
                            <div class="col-sm-8">
                                <div class="d-flex align-items-left flex-wrap row-gap-2">
                                    <a href="javascript:void(0)" id="openModal" class="btn btn-primary">
                                        <i class="ti ti-square-rounded-plus me-2"></i>Add Parent Category
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-table">
                            <table class="table" id="category_table">
                                <button class="btn btn-primary" id="bulk_delete_button" style="display: none;">Delete
                                    Selected</button>
                                <thead class="thead-light">
                                    <tr>
                                        <th hidden>ID</th>
                                        <th class="no-sort" scope="col">Sr no</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                </div>
                <div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Add Parent Category</h5>
                                {{-- <button type="button" class="btn-close close_poup" data-bs-dismiss="modal"></button> --}}
                                <button class="btn-close custom-btn-close border p-1 me-0 text-dark"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ti ti-x"></i>
                            </div>
                            <div class="modal-body">
                                <form id="categoryForm">
                                    @csrf
                                    <input type="hidden" name="category_id">

                                    <div class="mb-3">
                                        <label class="col-form-label">Category Name *</span></label>
                                        <input type="text" name="category_name" value=""
                                            class="form-control" placeholder="Enter category name" maxlength="250">
                                        <input type="hidden" name="parent_category_id" value="0">
                                        <span class="category_name_error"></span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Status</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <input type="radio" class="status-radio" id="active1"
                                                    name="status" value="1"
                                                    {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                                <label for="active1">Active</label>
                                            </div>
                                            <div>
                                                <input type="radio" class="status-radio" id="inactive1"
                                                    name="status" value="0"
                                                    {{ old('status') == '0' ? 'checked' : '' }}>
                                                <label for="inactive1">Inactive</label>
                                            </div>
                                        </div>
                                        @error('status')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="float-end">
                                        <button type="button" class="btn btn-light me-2 close_poup"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--C O M P A N Y   D E T A I L S   T A B-->
            <div class="tab-pane fade {{ $activeTab == 'company-detail' ? 'show active' : '' }}" id="company-details"
                role="tabpanel" aria-labelledby="CompanyDetails">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="company-detail">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    @if (getSetting('company_logo') && !empty(getSetting('company_logo')))
                                        <img id="companyLogoPreview"
                                            src="{{ getSetting('company_logo') ? asset('storage/company_logo/' . getSetting('company_logo')) : asset('images/default-user.png') }} "
                                            alt="Profile Picture"class="img-thumbnail mb-2" width="100%"
                                            height="100%" style="object-fit: contain" alt="Profile Picture">
                                    @endif
                                </div>

                                <div class="upload-content">
                                    <div class="upload-btn @error('company_logo') is-invalid @enderror">
                                        <input type="file" name="company_logo" accept=".jpg,.jpeg,.gif,.png"
                                            onchange="previewProfilePicture(event, 'companyLogoPreview')">
                                        <span><i class="ti ti-file-broken"></i>Company Logo</span>
                                    </div>
                                    <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                    @error('company_logo')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Company Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('company_email') is-invalid @enderror"
                                    name="company_email"
                                    value="{{ old('company_email', getSetting('company_email')) }}">
                                @error('company_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Company Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="number"
                                    class="form-control @error('company_phone') is-invalid @enderror"
                                    name="company_phone"
                                    value="{{ old('company_phone', getSetting('company_phone')) }}"
                                    oninput="this.value = this.value.slice(0, 11)">
                                @error('company_phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Company Address<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('company_address') is-invalid @enderror" name="company_address">{{ old('company_address', getSetting('company_address')) }}</textarea>
                                @error('company_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Distributor Payment Reminder Interval <span
                                        class="text-danger">* NOTE: input value consider will be days.</span></label>
                                <input type="number"
                                    class="form-control @error('distributor_payment_reminder_interval') is-invalid @enderror"
                                    name="distributor_payment_reminder_interval"
                                    value="{{ old('distributor_payment_reminder_interval', getSetting('distributor_payment_reminder_interval')) }}">
                                @error('distributor_payment_reminder_interval')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Dealer Payment Reminder <span class="text-danger">* NOTE:
                                        input value consider will be days.</span></label>
                                <input type="number"
                                    class="form-control @error('dealer_payment_reminder_interval') is-invalid @enderror"
                                    name="dealer_payment_reminder_interval"
                                    value="{{ old('dealer_payment_reminder_interval', getSetting('dealer_payment_reminder_interval')) }}">
                                @error('dealer_payment_reminder_interval')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}


                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">GST(%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('gst') is-invalid @enderror"
                                    name="gst" value="{{ old('gst', getSetting('gst')) }}">
                                @error('gst')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--E M A I L   D E T A I L S   T A B-->
            <div class="tab-pane fade {{ $activeTab == 'email-detail' ? 'show active' : '' }}" id="email-detail"
                role="tabpanel" aria-labelledby="EmailDetails">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="email-detail">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="col-form-label">Email Template Header<span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control summernote @error('email_template_header') is-invalid @enderror"
                                name="email_template_header">{{ old('email_template_header', getSetting('email_template_header')) }}</textarea>
                            @error('email_template_header')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="col-form-label">Email Template Footer<span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control summernote @error('email_template_footer') is-invalid @enderror"
                                name="email_template_footer">{{ old('email_template_footer', getSetting('email_template_footer')) }}</textarea>
                            @error('email_template_footer')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

            <!--D I S T R I B U T O R S   &   D E A L E R S   T A B-->
            <div class="tab-pane fade {{ $activeTab == 'distributors-dealers' ? 'show active' : '' }}"
                id="Distributors-Dealers" role="tabpanel" aria-labelledby="DistributorsDealers">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="distributors-dealers">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="col-form-label">Distributors Payment Reminder <span
                                    class="text-danger">*</span></label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('distributor_credit_limit') is-invalid @enderror"
                                    placeholder="0" name="distributor_credit_limit"
                                    value="{{ old('distributor_credit_limit', getSetting('distributor_credit_limit')) }}">
                                <div class="form-input-icon select-2-box">
                                    <select class="select2" id="distributor_cr_limit_type"
                                        name="distributor_cr_limit_type" aria-hidden="true" style="width:100%">
                                        <option value="day"
                                            {{ old('distributor_cr_limit_type', getSetting('distributor_cr_limit_type')) == 'day' ? 'selected' : '' }}>
                                            Days</option>
                                        <option value="month"
                                            {{ old('distributor_cr_limit_type', getSetting('distributor_cr_limit_type')) == 'month' ? 'selected' : '' }}>
                                            Month</option>
                                    </select>
                                </div>
                                @error('distributor_credit_limit')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label class="col-form-label">Dealer Payment Reminder <span
                                    class="text-danger">*</span></label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number"
                                    class="form-control @error('dealer_credit_limit') is-invalid @enderror"
                                    name="dealer_credit_limit" placeholder="0"
                                    value="{{ old('dealer_credit_limit', getSetting('dealer_credit_limit')) }}">
                                <div class="form-input-icon select-2-box">
                                    <select class="select2" id="dealer_cr_limit_type" name="dealer_cr_limit_type"
                                        aria-hidden="true" style="width:100%">
                                        <option value="day"
                                            {{ old('dealer_cr_limit_type', getSetting('dealer_cr_limit_type')) == 'day' ? 'selected' : '' }}>
                                            Days</option>
                                        <option value="month"
                                            {{ old('dealer_cr_limit_type', getSetting('dealer_cr_limit_type')) == 'month' ? 'selected' : '' }}>
                                            Month</option>
                                    </select>
                                </div>
                                @error('dealer_credit_limit')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- O - F O R M-->
            <div class="tab-pane fade {{ $activeTab == 'o_form' ? 'show active' : '' }}" id="o_form"
                role="tabpanel" aria-labelledby="o_form">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="o_form">
                    <div class="upload-content">
                        <div class="mb-3 col-md-6">
                            <label for="docx_file" class="form-label">Upload Docx File</label>
                            <input type="file" name="o_form_docx_file" id="docx_file"
                                class="form-control @error('o_form_docx_file') is-invalid @enderror" accept=".docx">

                            @error('o_form_docx_file')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        {{-- Download Docx File Code --}}
                        {{-- {{dd(  storage_path().'/O-Form/' .getSetting('o_form_docx_file'))}} --}}
                        @if (getSetting('o_form_docx_file') && !empty(getSetting('o_form_docx_file')))
                            <a href="{{ asset('storage/O-Form/' . getSetting('o_form_docx_file')) }}?v={{ time() }}"
                                class="btn btn-outline-primary">
                                <i class="ti ti-download"></i> Download Docx File
                            </a>
                        @endif


                    </div>
                    {{-- <button type="submit" class="btn btn-primary">Replace Name</button> --}}
                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>


            <!-- P R I N C I P A L   C E R T I F I C A T E   F O R M-->
            <div class="tab-pane fade {{ $activeTab == 'principal_certificate' ? 'show active' : '' }}"
                id="principal_certificate" role="tabpanel" aria-labelledby="principal_certificate">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="principal_certificate">
                    <div class="upload-content">
                        <div class="mb-3 col-md-6">
                            <label for="docx_file" class="form-label">Upload Docx File</label>
                            <input type="file" name="principal_certificate_docx_file" id="docx_file"
                                class="form-control @error('principal_certificate_docx_file') is-invalid @enderror"
                                accept=".docx">

                            @error('principal_certificate_docx_file')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        {{-- Download Docx File Code --}}
                        {{-- {{dd(  storage_path().'/PRINCIPAL-CERTIFICATE/' .getSetting('principal_certificate_docx_file'))}} --}}
                        @if (getSetting('principal_certificate_docx_file') && !empty(getSetting('principal_certificate_docx_file')))
                            <a href="{{ asset('storage/PRINCIPAL-CERTIFICATE/' . getSetting('principal_certificate_docx_file')) }}?v={{ time() }}"
                                class="btn btn-outline-primary">
                                <i class="ti ti-download"></i> Download Docx File
                            </a>
                        @endif


                    </div>
                    {{-- <button type="submit" class="btn btn-primary">Replace Name</button> --}}
                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>

            <!--A D V A N C E   P A Y M E N T   D I S C O U N T   T A B-->
            <div class="tab-pane fade {{ $activeTab == 'advance-payment-discount' ? 'show active' : '' }}"
                id="Advance-Payment-Discount" role="tabpanel" aria-labelledby="AdvancePaymentDiscount">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="advance-payment-discount">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">Advance Payment Discount <span
                                    class="text-danger">*</span></label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('advance_payment_discount') is-invalid @enderror"
                                    placeholder="0" name="advance_payment_discount"
                                    value="{{ old('advance_payment_discount', getSetting('advance_payment_discount')) }}">
                                <div class="form-input-icon select-2-box">
                                    <select class="select2" id="discount_type" name="discount_type"
                                        aria-hidden="true" style="width:100%">
                                        <option value="rupees"
                                            {{ old('discount_type', getSetting('discount_type')) == 'rupees' ? 'selected' : '' }}>
                                            ₹</option>
                                        <option value="percentage"
                                            {{ old('discount_type', getSetting('discount_type')) == 'percentage' ? 'selected' : '' }}>
                                            %</option>
                                    </select>
                                </div>
                                @error('advance_payment_discount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--P D F   P R I C E   L I S T   T A B-->
            <div class="tab-pane fade {{ $activeTab == 'pdf-price-list' ? 'show active' : '' }}" id="Pdf-Price-List"
                role="tabpanel" aria-labelledby="PdfPriceList">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="pdf-price-list">
                    <h5>PRICELIST – {{ date('Y') }}</h5>
                    <div class="row mt-3">
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">ADVANCE</label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('advance') is-invalid @enderror" placeholder="0"
                                    name="advance" value="{{ old('advance', getSetting('advance')) }}">
                                @error('advance')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">15 Day's</label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('15_days') is-invalid @enderror" placeholder="0"
                                    name="15_days" value="{{ old('15_days', getSetting('15_days')) }}">
                                @error('15_days')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">30 Day's</label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('30_days') is-invalid @enderror" placeholder="0"
                                    name="30_days" value="{{ old('30_days', getSetting('30_days')) }}">
                                @error('30_days')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">45 Day's</label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('45_days') is-invalid @enderror" placeholder="0"
                                    name="45_days" value="{{ old('45_days', getSetting('45_days')) }}">
                                @error('45_days')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">60 Day's</label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('60_days') is-invalid @enderror" placeholder="0"
                                    name="60_days" value="{{ old('60_days', getSetting('60_days')) }}">
                                @error('60_days')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">90 Day's</label>
                            <div class="form-input-icon input-group gropinginput box-bordernone">
                                <input type="number" step="any"
                                    class="form-control @error('90_days') is-invalid @enderror" placeholder="0"
                                    name="90_days" value="{{ old('90_days', getSetting('90_days')) }}">
                                @error('90_days')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <h5>Terms & Conditions</h5>

                        <div class="col-md-12 mt-3">
                            <div class="mb-3">
                                <textarea class="form-control summernote @error('terms_and_condition') is-invalid @enderror"
                                    name="terms_and_condition">{{ old('terms_and_condition', getSetting('terms_and_condition')) }}</textarea>
                                @error('terms_and_condition')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h5>NOTE</h5>
                        <div class="col-md-12 mb-3 mt-3">
                            {{-- <label class="col-form-label"> --}}
                            {{-- </label> --}}
                            <textarea class="form-control @error('note') is-invalid @enderror" name="note">{{ old('note', getSetting('note')) }}</textarea>

                            @error('note')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <h5>Disclaimer</h5>

                        <div class="col-md-12 mt-3">
                            <div class="mb-3">
                                <textarea class="form-control summernote @error('disclaimer') is-invalid @enderror" name="disclaimer">{{ old('disclaimer', getSetting('disclaimer')) }}</textarea>
                                @error('disclaimer')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h5>PDF Footer </h5>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <div class="profile-pic-upload">
                                    <div class="profile-pic">
                                        @if (getSetting('pdf_logo') && !empty(getSetting('pdf_logo')))
                                            <img id="PDFlogoPreview"
                                                src="{{ getSetting('pdf_logo') ? asset('storage/pdf_logo/' . getSetting('pdf_logo')) : asset('images/default-user.png') }} "
                                                alt="Profile Picture"class="img-thumbnail mb-2" width="96.36px"
                                                height="100px" style="object-fit: contain" alt="Profile Picture">
                                        @endif
                                    </div>

                                    <div class="upload-content">
                                        <div class="upload-btn  @error('pdf_logo') is-invalid @enderror">
                                            <input type="file" name="pdf_logo" accept=".jpg,.jpeg,.gif,.png"
                                                onchange="previewProfilePicture(event, 'PDFlogoPreview')">
                                            <span>
                                                <i class="ti ti-file-broken"></i>PDF Logo
                                            </span>
                                        </div>
                                        <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                        @error('pdf_logo')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="col-form-label">Name </label>
                                <input type="text"
                                    class="form-control @error('pdf_footer_name') is-invalid @enderror"
                                    name="pdf_footer_name"
                                    value="{{ old('pdf_footer_name', getSetting('pdf_footer_name')) }}">
                                @error('pdf_footer_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label">Mobile </label>
                                <input type="number"
                                    class="form-control @error('pdf_footer_mobile') is-invalid @enderror"
                                    name="pdf_footer_mobile"
                                    value="{{ old('pdf_footer_mobile', getSetting('pdf_footer_mobile')) }}">
                                @error('pdf_footer_mobile')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label"> Email </label>
                                <input type="email"
                                    class="form-control @error('pdf_footer_email') is-invalid @enderror"
                                    name="pdf_footer_email"
                                    value="{{ old('pdf_footer_email', getSetting('pdf_footer_email')) }}">
                                @error('pdf_footer_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label">Address </label>
                                <textarea class="form-control @error('pdf_footer_address') is-invalid @enderror" name="pdf_footer_address">{{ old('pdf_footer_address', getSetting('pdf_footer_address')) }}</textarea>

                                @error('pdf_footer_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="col-form-label">Website URL </label>
                                <input type="text"
                                    class="form-control @error('pdf_footer_url') is-invalid @enderror"
                                    name="pdf_footer_url"
                                    value="{{ old('pdf_footer_url', getSetting('pdf_footer_url')) }}">
                                @error('pdf_footer_url')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.summernote').summernote({
            tabsize: 2,
            height: 350
        });
    });

    // function previewProfilePicture(event) {
    //     const file = event.target.files[0]; // Get the selected file
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             document.getElementById('profilePreview').src = e.target
    //                 .result; // Set image preview source
    //         }
    //         reader.readAsDataURL(file); // Read the file as a Data URL
    //     }
    // }
    function previewProfilePicture(event, targetId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const image = document.getElementById(targetId);
                if (image) {
                    image.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // 

    /***** Open Modal for Add a New product category *****/
    $('#openModal').click(function() {
        $('#categoryForm')[0].reset();
        $('#adminModal').modal('show');
        $('#modalTitle').text('Add Parent Category');
        $('#submitBtn').text('Create');
        $('input[name="category_id"]').val('');
        $('select[name="parent_category_id"]').parent().show();
        $("#categoryForm .text-danger").text('');
        $('#categoryForm').find('.is-invalid').removeClass('is-invalid');
    });

    /***** Open Modal for Editing an Admin *****/
    $(document).on('click', '.edit-btn', function() {
        let category_id = $(this).data('id');
        // alert(category_id);
        $("#categoryForm .text-danger").text('');
        $('#categoryForm').find('.is-invalid').removeClass('is-invalid');

        $.get('{{ route('category.edit', ':id') }}'.replace(':id', category_id), function(category) {
            console.log(category);
            $('#modalTitle').text('Edit Parent Category');
            $('#submitBtn').text('Update');
            $('input[name="category_id"]').val(category_id);

            if (category.parent_category_id !== null && category.parent_category_id !== undefined &&
                category.parent_category_id != 0) {
                $('select[name="parent_category_id"]').val(category.parent_category_id).trigger(
                    'change');
                $('select[name="parent_category_id"]').parent().show();
            } else {
                $('select[name="parent_category_id"]').val(0).trigger('change');
                $('select[name="parent_category_id"]').parent().hide();
            }

            $('input[name="category_name"]').val(category.category_name);
            $('input[name="status"][value="' + category.status + '"]').prop('checked', true);
            $('#adminModal').modal('show');
        });
    });

    /***** Add & Edit Form Submission *****/
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        let category_id = $('input[name="category_id"]').val();
        let url = category_id ? '{{ route('category.update', ':id') }}'.replace(':id', category_id) :
            "{{ route('category.store') }}";
        let method = category_id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize() + "&_method=" + method,
            success: function(response) {
                $('#adminModal').modal('hide');
                category_table_show.ajax.reload();
                show_success(response.message);
            },
            error: function(response) {
                display_errors(response.responseJSON.errors);
            }
        });
    });

    function display_errors(errors) {
        $("#categoryForm .error-text").text('');
        $.each(errors, function(key, value) {
            $('input[name=' + key + ']').addClass('is-invalid');
            console.log($('input[name=' + key + ']'));
            $('.' + key + '_error').text(value[0]).addClass('text-danger');
        });
    }

    var category_table_show = $('#category_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: {
            url: '{{ route('category.index') }}',
            data: function(d) {
                d.show_parent = true; // Unique identifier for this table
            },
        },
        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'category_name',
                name: 'category_name',
                searchable: true
            },
            {
                data: 'status',
                name: 'status',
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],

    });

    function confirmDeletion(callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this category? Once deleted, it cannot be recovered.",
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

    /***** Delete *****/
    $(document).on('click', '.deleteCategory', function(event) {
        event.preventDefault();
        let categoryId = $(this).data('id');
        let form = $('#delete-form-' + categoryId); // Select the correct form
        console.log(form);
        let actionUrl = "{{ route('category.destroy', ':id') }}".replace(':id', categoryId);
        // Submit ajax if confirmed
        confirmDeletion(function() {
            $.ajax({
                url: actionUrl,
                type: "POST", // because it's destroy
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                }, // Laravel requires CSRF token
                success: function(response) {
                    // ✅ Remove deleted row from table (example)
                    category_table_show.ajax.reload();
                    show_success(response.message);
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        });
        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "You want to remove this category? Once deleted, it cannot be recovered.",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: 'Yes, delete it!',
        //     cancelButtonText: 'Cancel',
        //     customClass: {
        //         popup: 'my-custom-popup', // Custom class for the popup
        //         title: 'my-custom-title', // Custom class for the title
        //         confirmButton: 'btn btn-primary', // Custom class for the confirm button
        //         cancelButton: 'btn btn-secondary', // Custom class for the cancel button
        //         icon: 'my-custom-icon swal2-warning'
        //     }
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         form.submit(); // Submit form if confirmed
        //     }
        // });
    });
</script>
@endsection
