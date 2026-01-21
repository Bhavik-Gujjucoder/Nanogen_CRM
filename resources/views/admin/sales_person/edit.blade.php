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
        <form action="{{ route('sales_person.update', $detail->id) }}" id="myForm" enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-pic-upload">
                            <div class="profile-pic">
                                {{-- <img id="profilePreview"
                                    src="{{ asset('storage/profile_pictures/' . ($detail->user->profile_picture ?? 'images/default-user.png')) }}"
                                    alt="Profile Image" class="img-thumbnail mb-2"> --}}

                                <img id="profilePreview"
                                    src="{{ $detail->user && $detail->user->profile_picture
                                        ? asset('storage/profile_pictures/' . $detail->user->profile_picture)
                                        : asset('images/default-user.png') }}"
                                    alt="Profile Image" class="img-thumbnail mb-2">
                            </div>
                            <div class="upload-content">
                                <div class="upload-btn">
                                    <input type="file" name="profile_picture" accept=".jpg,.jpeg,.gif,.png"
                                        class="form-control @error('profile_picture') is-invalid @enderror"
                                        onchange="previewProfilePicture(event)">
                                    <span>
                                        <i class="ti ti-file-broken"></i> Upload Profile Image
                                    </span>
                                </div>
                                <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                {{-- <div id="profile_picture" class="error-message text-danger"></div> --}}
                                @error('profile_picture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $detail->first_name) }}"
                                class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name"
                                maxlength="255">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $detail->last_name) }}"
                                class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name"
                                maxlength="255">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Email </label>
                            <input type="text" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $detail->user->email) }}" placeholder="Email" maxlength="255">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                name="phone_number" value="{{ old('phone_number', $detail->user->phone_no) }}"
                                placeholder="Phone Number"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                            @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Password <span class="text-danger">*</span></label>

                            <div class="icon-form-end">
                                <span class="form-icon"><i class="ti ti-eye-off"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" maxlength="255">
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
                                    name="password_confirmation" placeholder="Confirm Password" maxlength="255">
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
                            <input type="text" class="form-control" name="employee_id"
                                value="{{ $detail->employee_id }}" placeholder="Employee ID" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                            <select class="select @error('department_id') is-invalid @enderror" name="department_id">
                                <option value="">Select Department</option>
                                @foreach ($departments as $d)
                                    <option value="{{ $d->id }}"
                                        {{ old('department_id', $detail->department_id) == $d->id ? 'selected' : '' }}>
                                        {{ $d->name }}</option>
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
                                <option value="">Select Position</option>
                                @foreach ($positions as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('position_id', $detail->position_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}</option>
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
                                <option value="">Select Reporting Manager</option>
                                @foreach ($reporting_managers as $manager)
                                    <option value="{{ $manager->id }}"
                                        {{ old('reporting_manager_id', $detail->reporting_manager_id) == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}</option>
                                @endforeach
                            </select>
                            @error('reporting_manager_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- <div class="mb-3">
                            <label class="col-form-label">Date <span class="text-danger">*</span></label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="date" vvalue="{{ old('date', optional($detail->date)->format('d-m-Y')) }}"
                                    class="form-control datetimepicker @error('date') is-invalid @enderror">
                            </div>
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="mb-3">
                            <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="date" id="datePicker"
                                    value="{{ old('date', isset($detail) ? \Carbon\Carbon::parse($detail->date)->format('d-m-Y') : now()->format('d-m-Y')) }}"
                                    class="form-control @error('date') is-invalid @enderror">
                            </div>
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Reporting Sales Person</label>
                            @if (!auth()->user()->hasRole('sales'))
                                <select name="reporting_sales_person_id" class="select ">
                                    <option value="">Select Sales Person</option>
                                    @foreach ($sales_person as $person)
                                        <option value="{{ $person->user_id }}"
                                            {{ old('reporting_sales_person_id', $detail->reporting_sales_person_id) == $person->user_id ? 'selected' : '' }}>
                                            {{ $person->first_name . ' ' . $person->last_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select name="reporting_sales_person_id" class="select">
                                    <option value="">Select Sales Person</option>
                                    @foreach ($reporting_sales_person as $person)
                                        <option value="{{ $person->user_id }}"
                                            {{ old('reporting_sales_person_id', $detail->reporting_sales_person_id) == $person->user_id ? 'selected' : '' }}>
                                            {{ $person->first_name . ' ' . $person->last_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="jobdetail mb-4">
                <h5 class="mb-3">Address Details</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" name="street_address"
                                value="{{ old('street_address', $detail->street_address) }}"
                                class="form-control @error('street_address') is-invalid @enderror"
                                placeholder="Street Address" maxlength="255">
                            @error('street_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">State/Province <span class="text-danger">*</span></label>
                            <select id="stateDropdown" class="form-select @error('state_id') is-invalid @enderror"
                                name="state_id">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('state_id', $detail->state_id) == $state->id ? 'selected' : '' }}>
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">City <span class="text-danger">*</span></label>
                            <select id="cityDropdown" class="form-select @error('city_id') is-invalid @enderror"
                                name="city_id">
                                <option value="">Select City</option>
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Area Of Operation <span class="text-danger">*</span></label>
                            <select id="AreaOfOperation"
                                class="form-select select2-element @error('city_ids') is-invalid @enderror"
                                name="city_ids[]" multiple="multiple" data-old='@json(old('city_ids', []))'>
                                <option value="">Select City</option>
                            </select>
                            @error('city_ids')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Head Quarter </label>
                            <select id="head_quarter"
                                class="form-select select search-dropdown @error('head_quarter_city_id') is-invalid @enderror"
                                name="head_quarter_city_id">
                                <option value="">Select Head Quarter</option>
                            </select>
                            @error('head_quarter_city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Postal Code <span class="text-danger">*</span></label>
                            <input type="text" name="postal_code"
                                value="{{ old('postal_code', $detail->postal_code) }}"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                placeholder="Postal Code"
                                oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').slice(0, 6);">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                        <select id="inputState" class="form-select @error('country_id') is-invalid @enderror"
                            name="country_id">
                            <option value="">Select Country</option>
                            @foreach ($countries as $county)
                                <option value="{{ $county->id }}"
                                    {{ old('country_id', $detail->country_id) == $county->id ? 'selected' : '' }}>
                                    {{ $county->name }}
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
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
{{-- <script>
    $(document).ready(function() {
        const selectedStateId = '{{ $detail->state_id }}';
        const selectedCityId = '{{ $detail->city_id }}';
        const selectedAreaOfOperation = @json($detail->city_ids ?? []);
        console.log(selectedAreaOfOperation);
        // Load cities on page load
        if (selectedStateId) {
            loadCities(selectedStateId, selectedCityId, selectedAreaOfOperation);
        }

        // When user changes state
        $('#stateDropdown').on('change', function() {
            const stateId = $(this).val();
            loadCities(stateId, null, []); // reset selected city
        });

        function loadCities(stateId, selectedCityId, selectedAreaOfOperation) {
            $('#cityDropdown').html('<option value="">Loading...</option>');
            $('#AreaOfOperation').html('<option value="">Loading...</option>');

            $.ajax({
                url: "{{ route('get.cities') }}",
                type: "POST",
                data: {
                    state_id: stateId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    /* city dropdown */
                    $('#cityDropdown').empty().append('<option value="">Select City</option>');
                    $.each(data, function(index, city) {
                        const selected = city.id == selectedCityId ? 'selected' : '';
                        $('#cityDropdown').append('<option value="' + city.id + '" ' +
                            selected + '>' + city.city_name + '</option>');
                    });

                    $(".select2-element").select2({
                        allowClear: true,
                        width: '100%'
                    });

                    /* Area Of Operation dropdown */
                    // const normalized = (selectedAreaOfOperation || []).map(String);
                    $('#AreaOfOperation').empty().append('<option value="">Select City</option>');
                    $.each(data, function(index, city) {
                        const selected = selectedAreaOfOperation.includes(city.id.toString()) ? 'selected' : '';
                        console.log(selected);
                        $('#AreaOfOperation').append('<option value="' + city.id + '" ' +
                            selected + '>' + city.city_name + '</option>');
                    });

                    // Initialize Select2 after appending
                    $('#AreaOfOperation').select2({
                        allowClear: true,
                        width: '100%'
                    });

                    // Ensure values are selected
                    $('#AreaOfOperation').val(selectedAreaOfOperation).trigger('change');


                }
            });
        }
    });
</script> --}}


<script>
    $(document).ready(function() {
        const selectedStateId = '{{ $detail->state_id }}';
        const selectedCityId = '{{ $detail->city_id }}';
        // const selectedAreaOfOperation = @json($detail->city_ids ? explode(',', $detail->city_ids) : []);
        const selectedAreaOfOperation = '{{ $detail->city_ids }}'.split(',').map(
            Number); //@json($detail->city_ids ? explode(',', $detail->city_ids) : []);

        const selectedhead_quarter = '{{ $detail->head_quarter_city_id }}';

        // Load cities on page load
        if (selectedStateId) {
            loadCities(selectedStateId, selectedCityId, selectedAreaOfOperation, selectedhead_quarter);
            // loadCities(selectedStateId, selectedCityId, selectedhead_quarter);
        }

        // When user changes state
        $('#stateDropdown').on('change', function() {
            const stateId = $(this).val();
            loadCities(stateId, null, [], null); // reset both when changing state
        });

        function loadCities(stateId, selectedCityId, selectedAreaOfOperation, selectedhead_quarter) {
            $('#cityDropdown').html('<option value="">Loading...</option>');
            $('#AreaOfOperation').html('<option value="">Loading...</option>');
            $('#head_quarter').html('<option value="">Loading...</option>');

            $.ajax({
                url: "{{ route('get.cities') }}",
                type: "POST",
                data: {
                    state_id: stateId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    /* ---------------- Single City Dropdown ---------------- */
                    $('#cityDropdown').empty().append('<option value="">Select City</option>');
                    $.each(data, function(index, city) {
                        let isSelected = (String(city.id) === String(selectedCityId)) ?
                            'selected="selected"' : '';
                        $('#cityDropdown').append('<option value="' + city.id + '" ' +
                            isSelected + '>' + city.city_name + '</option>');
                    });

                    /* ------------------------------------------------ 
                            Area Of Operation Multi Dropdown         
                    ------------------------------------------------ */
                    $('#AreaOfOperation').empty();
                    $.each(data, function(index, city) {
                        // let isSelected = selectedAreaOfOperation.includes(String(city.id)) ?
                        //     'selected="selected"' : '';

                        let isSelected = selectedAreaOfOperation.includes(Number(city.id)) ?
                            'selected="selected"' : '';

                        $('#AreaOfOperation').append('<option value="' + city.id + '" ' +
                            isSelected + '>' + city.city_name + '</option>');
                    });

                    // Re-init Select2 after adding options
                    $('#AreaOfOperation').select2({
                        allowClear: true,
                        width: '100%'
                    });

                    // Ensure values are selected in case of async
                    $('#AreaOfOperation').val(selectedAreaOfOperation).trigger('change');

                    /* -------------------------
                            Head Quarter 
                    ---------------------------- */
                    $('#head_quarter').empty();
                    $.each(data, function(index, city) {
                        // let isSelected = selectedhead_quarter.includes(String(city.id)) ?
                        //     'selected="selected"' : '';
                        let isSelected = String(city.id) === String(selectedhead_quarter) ?
                            'selected="selected"' : '';

                        $('#head_quarter').append('<option value="' + city.id + '" ' +
                            isSelected + '>' + city.city_name + '</option>');
                    });

                    /* Re-init Select2 after adding options */
                    $('#head_quarter').select2({
                        allowClear: false,
                        width: '100%'
                    });

                    /* Ensure values are selected in case of async */
                    $('#head_quarter').val(selectedhead_quarter).trigger('change');
                }
            });
        }
    });
</script>
<script>
    flatpickr("#datePicker", {
        dateFormat: "d-m-Y",
        disableMobile: true,
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
