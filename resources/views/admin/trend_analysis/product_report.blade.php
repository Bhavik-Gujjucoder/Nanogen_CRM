@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="card flex-fill">
            <div class="card-body">
                <form method="GET" action="{{ route('trend_analysis.product_report') }}{{-- route('sales_person.sales_report', ['id' => $sales_user]) --}}" class="row align-items-end g-3 mb-4"
                    id="dateFilterForm">

                    <div class="col-md-2">
                        <div class="mb-0">
                            <label class="col-form-label">Product</label>
                            <div class="icon-form">
                                <select name="product_id" class="form-control select">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" 
                                            {{ request()->input('product_id') == $product->id ? 'selected' : '' }}
                                            >{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-0">
                            <label class="col-form-label">Area/City</label>
                            <div class="icon-form">
                                <select name="city_id" class="form-control select">
                                    <option value="">Select</option>
                                    @foreach ($citys as $city)
                                        <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-0">
                            <label class="col-form-label">Start Date</label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="start_date"
                                    value="{{ old('start_date', request()->start_date) }}" id="startDate"
                                    class="form-control" placeholder="DD/MM/YY" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-0">
                            <label class="col-form-label">End Date</label>
                            <div class="icon-form">
                                <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                <input type="text" name="end_date" value="{{ old('end_date', request()->end_date) }}"
                                    id="endDate" class="form-control" placeholder="DD/MM/YY" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('trend_analysis.product_report') }}{{-- route('sales_person.sales_report', ['id' => $sales_user]) --}}"
                            class="btn btn-light w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row p-3" >
                <div class="col-md-2 offset-md-1">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">Number of Orders</h6>
                            <h4 class="mb-0 text-muted text-muted">{{ $number_of_orders }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">Total Sales</h6>
                            <h4 class="mb-0 text-muted text-muted">500 Kg</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">1 KG Packing</h6>
                            <h4 class="mb-0 text-muted">200</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">4 KG Packing</h6>
                            <h4 class="mb-0 text-muted">300</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">Revenue</h6>
                            <h4 class="mb-0 text-muted">₹5,00,000</h4>
                        </div>
                    </div>
                </div>

                
            </div> <!-- end row -->
        </div>
    </div>
</div>



@endsection
@section('script')
<script>
    /*** datepicker ***/
    $(document).ready(function() {
        const startPicker = flatpickr("#startDate", {
            dateFormat: "d-m-Y",
            maxDate: "today",
            defaultDate: "{{ old('start_date', request()->start_date) }}",
            onChange: function(selectedDates, dateStr, instance) {
                // Set selected start date as minDate for end date
                endPicker.set('minDate', dateStr);
                removeTodayHighlight(selectedDates, dateStr, instance);
            },
            onReady: removeTodayHighlight,
            onMonthChange: removeTodayHighlight,
            onYearChange: removeTodayHighlight,
            onOpen: removeTodayHighlight
        });

        const endPicker = flatpickr("#endDate", {
            dateFormat: "d-m-Y",
            maxDate: "today",
            defaultDate: "{{ old('end_date', request()->end_date) }}",
            onReady: removeTodayHighlight,
            onMonthChange: removeTodayHighlight,
            onYearChange: removeTodayHighlight,
            onOpen: removeTodayHighlight
        });

        function removeTodayHighlight(selectedDates, dateStr, instance) {
            const todayElem = instance.calendarContainer.querySelector(".flatpickr-day.today");
            if (todayElem && !todayElem.classList.contains("selected")) {
                todayElem.classList.remove("today");
            }
        }
    });

    /*** END ***/
</script>
@endsection
