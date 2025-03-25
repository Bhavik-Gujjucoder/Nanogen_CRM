@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">


        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="form-tab" data-bs-toggle="tab" href="#company-details" role="tab"
                    aria-controls="company-details" aria-selected="true">Company Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="blank-tab-1" data-bs-toggle="tab" href="#email-detail" role="tab"
                    aria-controls="email-detail" aria-selected="false">Email Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="blank-tab-2" data-bs-toggle="tab" href="#blank-tab-2-content" role="tab"
                    aria-controls="blank-tab-2-content" aria-selected="false">Tab 3</a>
            </li>
        </ul>


        {{-- <div class="tab-content mt-3" id="myTabContent"> --}}


        <form action="{{ route('admin.generalsetting.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="company-details" role="tabpanel" aria-labelledby="form-tab">
                    <input type="hidden" name="form_type" value="company-detail">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic">

                                    @if (getSetting('company_logo') && !empty(getSetting('company_logo')))
                                        <img id="profilePreview"
                                            src="{{ getSetting('company_logo') ? asset('storage/company_logo/' . getSetting('company_logo')) : asset('images/default-user.png') }} "
                                            alt="Profile Picture"class="img-thumbnail mb-2" width="100%"
                                            height="100%" style="object-fit: contain" alt="Profile Picture">
                                    @endif
                                </div>
                                <div class="upload-content">
                                    <div class="upload-btn @error('company_logo') is-invalid @enderror">
                                        <input type="file" name="company_logo" accept="image/*">
                                        <span><i class="ti ti-file-broken"></i>Company Logo</span>
                                    </div>
                                    <p>JPG, GIF or PNG. Max size of 2MB</p>
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
                                <input type="text" class="form-control @error('company_email') is-invalid @enderror"
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
                                <input type="number" class="form-control @error('company_phone') is-invalid @enderror"
                                    name="company_phone" value="{{ old('company_phone', getSetting('company_phone')) }}"
                                    oninput="this.value = this.value.slice(0, 11)">
                                @error('company_phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Company Address<span class="text-danger">*</span></label>
                                <textarea class="form-control @error('company_address') is-invalid @enderror" name="company_address">{{ old('company_address', getSetting('company_address')) }}</textarea>
                                @error('company_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

        <!-- Email Details -->
        <form action="{{ route('admin.generalsetting.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade" id="email-detail" role="tabpanel" aria-labelledby="blank-tab-1">
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
                </div>
            </div>
        </form>

        <!-- Blank Tab 2 (No Content) -->
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade" id="blank-tab-2-content" role="tabpanel" aria-labelledby="blank-tab-2">
                <!-- Empty Content Here -->
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
</script>
@endsection
