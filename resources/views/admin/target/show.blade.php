@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row">
                <!-- Target Name -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Name</label>
                        <p class="form-control-plaintext">{{ $target->subject }}</p>
                    </div>
                </div>

                <!-- Sales Person Name -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Sales Person Name</label>
                        <p class="form-control-plaintext">
                            {{ optional($salesmans->firstWhere('user_id', $target->salesman_id))->first_name ?? '' }}
                            {{ optional($salesmans->firstWhere('user_id', $target->salesman_id))->last_name ?? '' }}
                        </p>
                    </div>
                </div>

                <!-- Region -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Region</label>
                        <p class="form-control-plaintext">
                            {{ optional($cities->firstWhere('id', $target->city_id))->city_name }}
                        </p>
                    </div>
                </div>

                <!-- Target Value -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Value</label>
                        <p class="form-control-plaintext">{{ number_format($target->target_value) }}</p>
                    </div>
                </div>

                <!-- Wrap a full quarterly + grade block -->
                <div id="out_of_percentage" class="text-danger mb-2" style="display:block;"></div>
                @if ($target->target_quarterly)
                    @foreach ($target->target_quarterly as $q => $quarterly)
                        <div class="quarterly-block mb-4 p-3 border rounded">
                            <!-- quarterly Section -->
                            <div class="row align-items-center gap-0 quarterly-row">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="col-form-label flex-shrink-0">Quarterly </label>
                                        <div>
                                            @if ($quarterly->quarterly == '1')
                                                Quarterly 1
                                            @elseif ($quarterly->quarterly == '2')
                                                Quarterly 2
                                            @elseif ($quarterly->quarterly == '3')
                                                Quarterly 3
                                            @elseif ($quarterly->quarterly == '4')
                                                Quarterly 4
                                            @endif
                                        </div>


                                        {{-- <select class="form-control me-2" name="quarterly[]" disabled>
                                            <option value="">Select Quarter</option>
                                            <option value="1" {{ $quarterly->quarterly == '1' ? 'selected' : '' }}>
                                                Quarterly 1
                                            </option>
                                            <option value="2" {{ $quarterly->quarterly == '2' ? 'selected' : '' }}>
                                                Quarterly 2
                                            </option>
                                            <option value="3" {{ $quarterly->quarterly == '3' ? 'selected' : '' }}>
                                                Quarterly 3
                                            </option>
                                            <option value="4" {{ $quarterly->quarterly == '4' ? 'selected' : '' }}>
                                                Quarterly 4
                                            </option>
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="col-form-label flex-shrink-0">Quarterly Percentage </label>
                                        <input type="number" name="quarterly_percentage[]" disabled
                                            value="{{ old('quarterly_percentage', $quarterly->quarterly_percentage) }}"
                                            class="form-control me-2 quarterly-percentage"
                                            placeholder="Quarterly Percentage" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="col-form-label flex-shrink-0">Target Value </label>
                                        <input type="text" name="quarterly_target_value[]" disabled
                                            value="₹{{ number_format($quarterly->quarterly_target_value, 0) }}"
                                            class="input-as-text quarterly-target-value" placeholder="₹0" readonly>
                                    </div>
                                </div>
                                {{-- @if ($loop->first)
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger quarter-btn add-quarter">Add New
                                            Quarter</button>
                                    </div>
                                @else
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-dark quarter-btn remove-quarter">Remove
                                            Quarter</button>
                                    </div>
                                @endif --}}
                            </div>

                            <!-- Grade Section -->
                            <div class="grade-section mt-3">
                                @foreach ($quarterly->target_grade as $g => $tgrade)
                                    @if ($loop->first)
                                        <!-- Grade Heading -->
                                        <div class="row fw-bold">
                                            <div class="col-md-4">Grade </div>
                                            <div class="col-md-3">Target Percentage
                                            </div>
                                            <div class="col-md-3">Target Value </div>
                                        </div>
                                    @endif
                                    <!-- Grade Row -->
                                    <div class="product-group d-flex align-items-center mb-2">
                                        <div class="col-md-4">
                                            <select class="form-control me-2 selectGrade" disabled
                                                name="grade_id[{{ $q }}][]">
                                                <option value="">Select Grade</option>
                                                @if ($grade)
                                                    @foreach ($grade as $gr)
                                                        <option value="{{ $gr->id }}"
                                                            {{ $tgrade->grade_id == $gr->id ? 'selected' : '' }}>
                                                            {{ $gr->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No record</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="grade_percentage[{{ $q }}][]"
                                                disabled
                                                value="{{ old('grade_percentage', $tgrade->grade_percentage) }}"
                                                class="form-control me-2 grade-percentage"
                                                placeholder="Target Percentage">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="grade_target_value[{{ $q }}][]"
                                                disabled value="₹{{ number_format($tgrade->grade_target_value, 0) }}"
                                                class="input-as-text grade-target-value" placeholder="₹0" readonly>
                                        </div>
                                        {{-- <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-grade">Remove
                                                Grade</button>
                                        </div> --}}
                                    </div>
                                    {{-- @if ($loop->last)
                                        <!-- Add Grade Button -->
                                        <button type="button" class="btn btn-primary add-grade">Add New
                                            Grade</button>
                                    @endif --}}
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                @endif

                <div id="quarterlyError" class="text-danger mb-2" style="display:none;"></div>

            </div>
            {{-- <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update Target</button>
            </div> --}}
        </div>
    </div>

@endsection
