@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form action="{{ route('target.store') }}" id="myForm" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"
                            placeholder="Subject">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Sales Person Name <span class="text-danger">*</span></label>
                        <select name="salesman_id" class="form-control form-select search-dropdown">
                            <option value="">Select</option>
                            @if ($salesmans)
                                @foreach ($salesmans as $s)
                                    <option value="{{ $s->user_id }}"
                                        {{ old('salesman_id') == $s->user_id ? 'selected' : '' }}>
                                        {{ $s->first_name . ' ' . $s->last_name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">No record</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Region <span class="text-danger">*</span></label>
                        <select class="select search-dropdown" name="city_id">
                            <option value="">Select</option>
                            @if ($cities)
                                @foreach ($cities as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('city_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->city_name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">No record</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Value <span class="text-danger">*</span></label>
                        <input type="number" name="target_value" value="{{ old('target_value') }}"
                            class="form-control">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Start Date <span class="text-danger">*</span></label>
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" name="start_date" value="{{ old('start_date') }}" id="datePicker"
                                class="form-control " placeholder="DD/MM/YY">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">End Date <span class="text-danger">*</span></label>
                        <div class="icon-form">
                            <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                            <input type="text" name="end_date" value="{{ old('end_date') }}" id="datePicker"
                                class="form-control " placeholder="DD/MM/YY">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Grade <span class="text-danger">*</span></label>
                        <div id="product-container">
                            <div class="product-group d-flex align-items-center mb-2">
                                <select class="form-select me-2" name="grade_id[]">
                                    <option value="">Select</option>
                                    @if ($grade)
                                        @foreach ($grade as $g)
                                            <option value="{{ $g->id }}"
                                                {{ old('grade_id') == $g->id ? 'selected' : '' }}>
                                                {{ $g->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No record</option>
                                    @endif
                                </select>
                                <input type="text" name="percentage[]" value="{{ old('percentage') }}"
                                    class="form-control me-2" placeholder="Target To (%)">

                                <input type="text" name="percentage_value[]" value="{{ old('percentage_value') }}"
                                    class="form-control me-2" placeholder="Target Value">

                                <button type="button" class="btn btn-danger btn-sm remove-btn">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm mt-2" id="add-new">Add New</button>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>


    </div>
</div>


@endsection
@section('script')
<script>
    /*** select option search functionality ***/
    $(document).ready(function() {
        $('.search-dropdown').select2({
            placeholder: "Select",
            // allowClear: true
        });
    });

    /*** datepicker ***/
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
    /*** END ***/

    /*** Validation ***/
    $("#myForm").validate({
        ignore: [],
        rules: {
            subject: {
                required: true
            },
            salesman_id: {
                required: true
            },
            city_id: {
                required: true
            },
            target_value: {
                required: true,
                number: true
            },
            start_date: {
                required: true
            },
            end_date: {
                required: true
            }
        },
        messages: {
            subject: "Please enter subject",
            salesman_id: "Please select a salesperson",
            city_id: "Please select a region",
            target_value: {
                required: "Please enter target value",
                number: "Please enter a valid number"
            },
            start_date: "Please select a start date",
            end_date: "Please select an end date"
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.addClass('text-danger');
                error.insertAfter(element.next('.select2'));
            } else {
                error.addClass('text-danger');
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid'); // Removed is-valid to prevent green tick
        }
    });
</script>
<script>
    document.getElementById('add-new').addEventListener('click', function() {
        let productContainer = document.getElementById('product-container');
        let newProductGroup = document.createElement('div');
        newProductGroup.classList.add('product-group', 'd-flex', 'align-items-center', 'mb-2');
        newProductGroup.innerHTML = `
            <select class="form-select me-2" name="grade_id[]">
                                    <option value="">Select</option>
                                    @if ($grade)
                                        @foreach ($grade as $g)
                                            <option value="{{ $g->id }}"
                                                {{ old('grade_id') == $g->id ? 'selected' : '' }}>
                                                {{ $g->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No record</option>
                                    @endif
                                </select>
             <input type="text" name="percentage[]" value="{{ old('percentage') }}"
                                    class="form-control me-2" placeholder="Target To (%)">

                                <input type="text" name="percentage_value[]" value="{{ old('percentage_value') }}"
                                    class="form-control me-2" placeholder="Target Value">

            <button type="button" class="btn btn-danger btn-sm remove-btn">Remove</button>
        `;
        productContainer.appendChild(newProductGroup);
    });

    document.getElementById('product-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-btn')) {
            event.target.parentElement.remove();
        }
    });
</script>
@endsection
