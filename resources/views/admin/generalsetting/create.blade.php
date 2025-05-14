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
        </ul>

        <div class="tab-content mt-3" id="myTabContent">

            <!--G E N E R A L   S E T T I N G   T A B-->
            <div class="tab-pane fade show active {{-- $activeTab == 'general-setting' ? 'show active' : '' --}}" id="general-setting"
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
                                <textarea class="form-control @error('copyright_msg') is-invalid @enderror" name="copyright_msg" placeholder="Copyright Message">{{ old('copyright_msg', getSetting('copyright_msg')) }}</textarea>
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

            <!--C O M P A N Y   D E T A I L S   T A B-->
            <div class="tab-pane fade {{ $activeTab == 'company-detail' ? 'show active' : '' }}" id="company-details"
                role="tabpanel" aria-labelledby="CompanyDetails">
                <form action="{{ route('admin.generalsetting.store') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">GST(%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('gst') is-invalid @enderror"
                                    name="gst" value="{{ old('gst', getSetting('gst')) }}">
                                @error('gst')
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
                        @if (getSetting('o_form_docx_file') && !empty(getSetting('o_form_docx_file')))
                            <a href="{{ asset('storage/O-Form/' . getSetting('o_form_docx_file')) }}"
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
</script>
@endsection
