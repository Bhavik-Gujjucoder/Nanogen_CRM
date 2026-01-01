<div class="row  target-form target-form-cls order-form-cls">

    <!-- Target Name -->
    <div class="sub-sec">
        <div class=" mb-2">
            <div class="target-sec">
                <label class="col-form-label">Target Name</label>
                <p class="form-control-plaintext">{{ $target->subject }}</p>
            </div>
        </div>

        <!-- Sales Person Name -->
        <div class=" mb-2">
            <div class="target-sec">
                <label class="col-form-label">Sales Person Name</label>
                <p class="form-control-plaintext">
                    {{ optional($salesmans->firstWhere('user_id', $target->salesman_id))->first_name ?? '' }}
                    {{ optional($salesmans->firstWhere('user_id', $target->salesman_id))->last_name ?? '' }}
                </p>
            </div>
        </div>

        <!-- Region -->
        <div class=" mb-2">
            <div class="target-sec">
                <label class="col-form-label">Region</label>
                <p class="form-control-plaintext">
                    {{ optional($cities->firstWhere('id', $target->city_id))->city_name }}
                </p>
            </div>
        </div>

        <!-- Target Value -->
        <div class=" mb-2">
            <div class="target-sec">
                <label class="col-form-label">Target Value</label>
                <p class="form-control-plaintext"> ₹{{ number_format($target->target_value) }}</p>
            </div>
        </div>
    </div>

    <!-- Wrap a full quarterly + grade block -->
    <div id="out_of_percentage" class="text-danger mb-2" style="display:block;"></div>
    @if ($target->target_quarterly)
        @foreach ($target->target_quarterly as $q => $quarterly)
            <div class="quarterly-block mb-4 p-3 border rounded">
                <!-- quarterly Section -->
                <div class="row gap-0 quarterly-row">
                    <div class="col-md-4">
                        <div class="quality-sec gap-2">
                            <label class="col-form-label flex-shrink-0">Quarterly : </label>
                            <div>
                                @if ($quarterly->quarterly == '1')
                                    <small>Quarterly 1</small>
                                @elseif ($quarterly->quarterly == '2')
                                    <small>Quarterly 2</small>
                                @elseif ($quarterly->quarterly == '3')
                                    <small>Quarterly 3</small>
                                @elseif ($quarterly->quarterly == '4')
                                    <small>Quarterly 4</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quality-sec gap-2">
                            <label class="col-form-label flex-shrink-0">Quarterly Percentage : </label>
                            <p class="form-control-plaintext">{{ $quarterly->quarterly_percentage }}%</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quality-sec gap-2">
                            <label class="col-form-label flex-shrink-0">Target Value : </label>
                            <p class="form-control-plaintext">
                                ₹{{ number_format($quarterly->quarterly_target_value, 0) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Grade Section -->
                <div class="grade-section mt-3">
                    @foreach ($quarterly->target_grade as $g => $tgrade)
                        <!-- Grade Row -->
                        <div class="product-group product-group-sec d-flex align-items-center mb-2">
                            <div class="col-md-4">
                                @if ($loop->first)
                                    <label class="col-form-label flex-shrink-0"> Grade </label>
                                @endif
                                <select class="form-control-plaintext no-arrow" disabled
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
                            <div class="col-md-4">
                                @if ($loop->first)
                                    <label class="col-form-label flex-shrink-0"> Target Percentage </label>
                                @endif
                                <p class="form-control-plaintext">{{ $tgrade->grade_percentage }}%</p>
                            </div>
                            <div class="col-md-4">
                                @if ($loop->first)
                                    <label class="col-form-label flex-shrink-0"> Target Value</label>
                                @endif
                                <p class="form-control-plaintext">₹{{ number_format($tgrade->grade_target_value, 0) }}
                                </p>
                                {{-- <input type="text" name="grade_target_value[{{ $q }}][]" disabled
                                    value="₹{{ number_format($tgrade->grade_target_value, 0) }}"
                                    class="form-control-plaintext" placeholder="₹0" readonly> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
    <div id="quarterlyError" class="text-danger mb-2" style="display:none;"></div>
</div>
