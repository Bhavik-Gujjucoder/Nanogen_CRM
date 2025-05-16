@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row">
                {{-- Target Name --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Name</label>
                        <p class="form-control-plaintext">{{ $target->subject }}</p>
                    </div>
                </div>

                {{-- Sales Person Name --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Sales Person Name</label>
                        <p class="form-control-plaintext">
                            {{ optional($salesmans->firstWhere('user_id', $target->salesman_id))->first_name ?? '' }}
                            {{ optional($salesmans->firstWhere('user_id', $target->salesman_id))->last_name ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Region --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Region</label>
                        <p class="form-control-plaintext">
                            {{ optional($cities->firstWhere('id', $target->city_id))->city_name }}
                        </p>
                    </div>
                </div>

                {{-- Target Value --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Value</label>
                        <p class="form-control-plaintext">{{ number_format($target->target_value) }}</p>
                    </div>
                </div>

                {{-- Start Date --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Start Date</label>
                        <p class="form-control-plaintext">{{ $target->start_date->format('d-m-Y') }}</p>
                    </div>
                </div>

                {{-- End Date --}}
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">End Date</label>
                        <p class="form-control-plaintext">{{ $target->end_date->format('d-m-Y') }}</p>
                    </div>
                </div>

                {{-- Grades Section --}}
                <div class="col-md-12">
                    <h5 class="mt-4">Target Grades</h5>
                    <div class="d-flex align-items-center mb-2">
                        <div class="col-md-4">
                            <label class="col-form-label">Grade</label>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Target Percentage</label>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Target Value</label>
                        </div>
                    </div>

                    @if ($target->target_grade)
                        @foreach ($target->target_grade as $t_g)
                            <div class="product-group d-flex align-items-center mb-2">
                                <div class="col-md-4">
                                    <p class="form-control-plaintext">
                                        {{ optional($grade->firstWhere('id', $t_g->grade_id))->name }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="form-control-plaintext">{{ $t_g->percentage }}%</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="form-control-plaintext">{{ IndianNumberFormat($t_g->percentage_value) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No grade data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
