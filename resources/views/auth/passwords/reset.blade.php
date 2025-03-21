@extends('layouts.auth')

@section('content')
    <div class="main-wrapper">

        <div class="account-content">
            <div class="d-flex flex-wrap w-100 vh-100 overflow-hidden account-bg-04"
                style="background-image:url({{ asset('images/reset-bg.jpg') }});">
                <div
                    class="d-flex align-items-center justify-content-center flex-wrap vh-100 overflow-auto p-4 w-50 bg-backdrop">
                    <form method="POST" action="{{ route('password.update') }}" class="flex-fill">
                        @csrf
                        <div class="mx-auto mw-450">
                            <div class="text-center mb-4">
                                <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Logo">
                            </div>
                            <div class="mb-4">
                                <h4 class="mb-2 fs-20">Reset Password?</h4>
                                <p>Enter New Password & Confirm Password to get inside</p>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('Email Address') }}</label>
                                <div class="pass-group">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">New Password</label>
                                <div class="pass-group">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input id="password" type="password"
                                        class="pass-input form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">
                                        <span class="ti toggle-password ti-eye-off"></span>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">New Confirm Password</label>
                                <div class="pass-group">
                                    <input id="password-confirm" type="password" class="pass-input form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                    <span class="ti toggle-password ti-eye-off"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Change Password</button>
                            </div>
                            <div class="mb-3 text-center">
                                <h6>Return to <a href="{{ route('login') }}" class="text-purple link-hover"> Login</a></h6>
                            </div>
                            <div class="text-center">
                                <p class="fw-medium text-gray">Copyright &copy; 2025 - Nanogen Agrochem Private Limited </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
