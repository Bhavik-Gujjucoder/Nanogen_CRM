@extends('layouts.main')
@section('content')
    <style>
        /* Header (month/year) styling */
        .flatpickr-current-month {
            font-weight: 600;
            font-size: 16px;
            color: #000;
        }

        /* Selected date styling */
        .flatpickr-day.selected {
            background: #007bff !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 6px;
        }
    </style>
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form action="{{ route('sales_person.store') }}" id="myForm" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="mb-4 icon-set">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="profile-pic-upload">
                            <div class="profile-pic">
                                <img id="profilePreview" src="{{ asset('images/default-user.png') }}"
                                    alt="Profile Picture" class="img-thumbnail mb-2">
                            </div>
                            <div class="upload-content">
                                <div class="upload-btn">
                                    <input type="file" name="profile_picture" id="profile_picture"
                                        onchange="previewProfilePicture(event)"
                                        class="form-control @error('profile_picture') is-invalid @enderror">
                                    <span>
                                        <i class="ti ti-file-broken"></i>Upload Profile Image
                                    </span>
                                </div>
                                <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                @error('profile_picture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number">
                            @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Password <span class="text-danger">*</span></label>

                            <div class="icon-form-end">
                                <span class="form-icon gc-icon-set"><i class="ti ti-eye-off"></i></span>
                                <input type="password"
                                    class="form-control icone @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="icon-form-end">
                                <span class="form-icon"><i class="ti ti-eye-off"></i></span>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jobdetail mb-4">
                <h5 class="mb-3">Job Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Employee ID</label>
                            <input type="text" class="form-control " name="employee_id" value="{{ $employeeId }}"
                                placeholder="Employee ID" readonly>
                            {{-- @error('employee_id')  @error('employee_id') is-invalid @enderror
                                <span class="text-danger">{{ $message }}</span>
                            @enderror --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                            <select class="select @error('department_id') is-invalid @enderror" name="department_id">
                                <option value="">Select option</option>
                                @foreach ($departments as $d)
                                    <option value="{{ $d->id }}"
                                        {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Position <span class="text-danger">*</span></label>
                            <select class="select @error('position_id') is-invalid @enderror" name="position_id">
                                <option value="">Select option</option>
                                @foreach ($positions as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('position_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Reporting Manager <span class="text-danger">*</span></label>
                            <select name="reporting_manager_id"
                                class="select @error('reporting_manager_id') is-invalid @enderror">
                                <option value="">Select option</option>
                                @foreach ($reporting_managers as $manager)
                                    <option value="{{ $manager->id }}"
                                        {{ old('reporting_manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}</option>
                                @endforeach
                            </select>
                            @error('reporting_manager_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="date" value="{{ old('date') }}" id="datePicker"
                                    class="form-control  @error('date') is-invalid @enderror">
                            </div>
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="jobdetail">
                <h5 class="mb-3">Address Details</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" name="street_address" value="{{ old('street_address') }}"
                                class="form-control @error('street_address') is-invalid @enderror"
                                placeholder="Street Address">
                            @error('street_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">State/Province <span class="text-danger">*</span></label>
                            <select id="stateDropdown" class="form-select @error('state_id') is-invalid @enderror"
                                name="state_id"> {{-- id="inputState" --}}
                                <option value="">Select state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->state_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">City <span class="text-danger">*</span></label>
                            <select id="cityDropdown" class="form-select @error('city_id') is-invalid @enderror"
                                name="city_id"> {{-- id="inputCity" --}}
                                <option value="">Select city</option>
                                {{-- @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->city_name }}
                                    </option>
                                @endforeach --}}
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Postal Code <span class="text-danger">*</span></label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                placeholder="Postal/Zip code">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                        <select id="inputState" class="form-select @error('country_id') is-invalid @enderror"
                            name="country_id">
                            <option value="">Select country</option>
                            @foreach ($countries as $county)
                                <option value="{{ $county->id }}"
                                    {{ old('country_id') == $county->id ? 'selected' : '' }}>{{ $county->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                {{-- <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a> --}}
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#stateDropdown').on('change', function() {
            var stateID = $(this).val();
            $('#cityDropdown').html('<option value="">Loading...</option>');

            if (stateID) {
                $.ajax({
                    url: "{{ route('get.cities') }}",
                    type: "POST",
                    data: {
                        state_id: stateID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#cityDropdown').empty().append(
                            '<option value="">Select City</option>');
                        $.each(data, function(key, city) {
                            $('#cityDropdown').append('<option value="' + city.id +
                                '">' + city.city_name + '</option>');
                        });
                    }
                });
            } else {
                $('#cityDropdown').html('<option value="">-- Select City --</option>');
            }
        });
    });
</script>
<script>
    flatpickr("#datePicker", {
        dateFormat: "d-m-Y",
        maxDate: "today",
        defaultDate: "{{ old('date', isset($detail) ? \Carbon\Carbon::parse($detail->date)->format('d-m-Y') : now()->format('d-m-Y')) }}",
        onReady: removeTodayHighlight,
        onMonthChange: removeTodayHighlight,
        onYearChange: removeTodayHighlight,
        onOpen: removeTodayHighlight,
        onChange: removeTodayHighlight
    });

    function removeTodayHighlight(selectedDates, dateStr, instance) {
        const todayElem = instance.calendarContainer.querySelector(".flatpickr-day.today");
        if (todayElem && !todayElem.classList.contains("selected")) {
            todayElem.classList.remove("today");
        }
    }

    $(document).ready(function() {
        $(document).on('click', '.form-icon', function() {
            let input = $(this).siblings("input");
            let icon = $(this).find("i");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("ti-eye-off").addClass("ti-eye");
            } else {
                input.attr("type", "password");
                icon.removeClass("ti-eye").addClass("ti-eye-off");
            }
        });
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
</script>
@endsection
