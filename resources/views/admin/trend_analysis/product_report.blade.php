@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="card flex-fill">
            <div class="card-body">
                <form method="GET" action="{{ route('trend_analysis.product_report') }}"
                    class="row align-items-end g-3 mb-4" id="dateFilterForm">
                    <div class="col-md-2">
                        <div class="mb-0">
                            <label class="col-form-label">Product</label>
                            <div class="icon-form">
                                <select name="product_id" class="form-control select search-dropdown">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ request()->input('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-0">
                            <label class="col-form-label">Area/City</label>
                            <div class="icon-form">
                                <select name="city_id" class="form-control select search-dropdown">
                                    <option value="">Select</option>
                                    @foreach ($citys as $city)
                                        <option value="{{ $city->id }}"
                                            @if ($city_id && $city->id == $city_id) selected @endif>{{ $city->city_name }}
                                        </option>
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
    <div class="card pro-ann-report-card">
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">Number of Orders</h6>
                            <h4 class="mb-0 text-muted text-muted">{{ $number_of_orders }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">Revenue</h6>
                            <h4 class="mb-0 text-muted">₹{{ number_format($revenue) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <h6 class="mb-2">Total Sales</h6>
                            @php
                                $grouped_variations = $variation_qty->groupBy(function ($variation) {
                                    return strtolower($variation->packing_size_unit); // Normalize unit for consistent grouping
                                });
                            @endphp

                            @foreach ($grouped_variations as $unit => $variations)
                                @php
                                    $totalQty = 0;
                                    foreach ($variations as $variation) {
                                        $totalQty += $variation->total_qty * $variation->packing_size_name;
                                    }
                                @endphp

                                <span class="mb-0 text-muted">
                                    {{-- ( --}} {{ number_format($totalQty) }} {{ ucfirst($unit) }}
                                    @if ($unit == 'kg' && $totalQty >= 1000)
                                        → {{ number_format($totalQty / 1000, 2) }} Tonne
                                    @endif {{-- ) --}}
                                </span><br>
                            @endforeach

                        </div>
                    </div>
                </div>

                @foreach ($variation_qty as $variation)
                    <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-lg-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-3">
                                <h6 class="mb-2">{{ $variation->packing_size_name }}
                                    {{ $variation->packing_size_unit }} Packing</h6>
                                <h4 class="mb-0 text-muted">{{ number_format($variation->total_qty) }} </h4>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div> <!-- end row -->
        </div>
    </div>
</div>

{{-- <pre>{{ print_r($city_wise_chart, true) }}</pre> --}}

@if ($city_wise_chart->isNotEmpty())
    <div class="col-md-12">
        <div class="card pro-ann-report-card">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="mb-2">City Wise Analysis </h5>
            </div>
            <div class="card-body pb-0">
                <canvas id="citywiseChart" height="100%"></canvas>
            </div>
        </div>
    </div>
@endif



@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
     /*** select option search functionality ***/
    $(document).ready(function() {
        $('.search-dropdown').select2({
            placeholder: "Select",
            // allowClear: true
        });
    });

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


    function number_format_indian(x) {
        x = x.toString().split('.')[0]; // Remove decimals if any
        let lastThree = x.substring(x.length - 3);
        let otherNumbers = x.substring(0, x.length - 3);
        if (otherNumbers !== '')
            lastThree = ',' + lastThree;
        return otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
    }


    const city_wise_chart = @json($city_wise_chart);
    const city_wise_chart_labels = city_wise_chart.map(d => d.city_name);
    const city_wise_chart_counts = city_wise_chart.map(d => d.amount);

    const city_wise_chart_draw = document.getElementById('citywiseChart').getContext('2d');
    const cityChart = new Chart(city_wise_chart_draw, {
        type: 'bar',
        data: {
            labels: city_wise_chart_labels,
            datasets: [{
                label: 'Orders',
                data: city_wise_chart_counts,
                backgroundColor: '#ff9933',
                borderRadius: 6,
                barThickness: 80, //30
                unitTooltips: city_wise_chart.map(d => d.unit_totals2) // Custom field
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    color: '#black',
                    anchor: 'center',
                    align: 'center',
                    font: {
                        weight: 'bold',
                        size: 16 //14
                    },
                    formatter: function(value) {
                        return '₹' + number_format_indian(value);
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const label = context.label;
                            const value = context.formattedValue;
                            const tooltip = context.dataset.unitTooltips?.[index] || '';

                            // return [
                            //     `${label}: ${value}`,
                            //     'Units wise:',
                            //     ...tooltip.split('\n')
                            // ];

                            const lines = tooltip
                                .split('\n')
                                .filter(line => line.trim() !== '') // optional: remove empty lines
                                .map(line => `• ${line}`); // bullet formatting

                            return [
                                `${label}: ${ '₹' + value}`, // Main value (add % if needed)
                                'Units wise:',
                                ...lines
                            ];


                        }
                    }
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Set the interval to 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        autoSkip: false,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
    /*** END ***/
</script>
@endsection
