@extends('layouts.main')
@section('content')
    <style>
        .input-as-text {
            border: none;
            background: transparent;
            box-shadow: none;
            padding: 0;
            margin: 0;
            outline: none;
        }
    </style>
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form action="{{ route('target.update', $target->id) }}" id="target_form" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Name <span class="text-danger">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject', $target->subject) }}"
                            class="form-control" placeholder="Target Name" maxlength="255">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Sales Person Name <span class="text-danger">*</span></label>
                        @if (auth()->user()->hasRole('sales'))
                            <input type="text" value="{{ auth()->user()->name }}" class="form-control" readonly>
                            <input type="hidden" name="salesman_id" value="{{ auth()->user()->id }}">
                        @else
                            <select name="salesman_id" class="form-control form-select search-dropdown">
                                <option value="">Select</option>
                                @if ($salesmans)
                                    @foreach ($salesmans as $s)
                                        <option value="{{ $s->user_id }}"
                                            {{ old('salesman_id', $target->salesman_id) == $s->user_id ? 'selected' : '' }}>
                                            {{ $s->first_name . ' ' . $s->last_name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No record</option>
                                @endif
                            </select>
                        @endif
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
                                        {{ old('city_id', $target->city_id) == $c->id ? 'selected' : '' }}>
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
                        <input type="number" name="target_value" id="mainTargetValue"
                            value="{{ old('target_value', $target->target_value) }}" class="form-control"
                            placeholder="Target Value">
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
                                        <label class="col-form-label flex-shrink-0">Quarterly <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select me-2 selectQuarter" name="quarterly[]">
                                            <option value="">Select Quarter</option>
                                            <option value="1"
                                                {{ $quarterly->quarterly == '1' ? 'selected' : '' }}>Quarterly 1
                                            </option>
                                            <option value="2"
                                                {{ $quarterly->quarterly == '2' ? 'selected' : '' }}>Quarterly 2
                                            </option>
                                            <option value="3"
                                                {{ $quarterly->quarterly == '3' ? 'selected' : '' }}>Quarterly 3
                                            </option>
                                            <option value="4"
                                                {{ $quarterly->quarterly == '4' ? 'selected' : '' }}>Quarterly 4
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="col-form-label flex-shrink-0">Quarterly Percentage <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="quarterly_percentage[]"
                                            value="{{ old('quarterly_percentage', $quarterly->quarterly_percentage) }}"
                                            class="form-control me-2 quarterly-percentage"
                                            placeholder="Quarterly Percentage">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="col-form-label flex-shrink-0">Target Value <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="quarterly_target_value[]"
                                            value="₹{{ number_format($quarterly->quarterly_target_value, 0) }}"
                                            class="input-as-text quarterly-target-value" placeholder="₹0" readonly>
                                    </div>
                                </div>
                                @if ($loop->first)
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger quarter-btn add-quarter">Add New
                                            Quarter</button>
                                    </div>
                                @else
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-dark quarter-btn remove-quarter">Remove
                                            Quarter</button>
                                    </div>
                                @endif
                            </div>

                            <!-- Grade Section -->
                            <div class="grade-section mt-3">
                                @foreach ($quarterly->target_grade as $g => $tgrade)
                                    @if ($loop->first)
                                        <!-- Grade Heading -->
                                        <div class="row fw-bold">
                                            <div class="col-md-4">Grade <span class="text-danger">*</span></div>
                                            <div class="col-md-3">Target Percentage <span class="text-danger">*</span>
                                            </div>
                                            <div class="col-md-3">Target Value <span class="text-danger">*</span></div>
                                        </div>
                                    @endif
                                    <!-- Grade Row -->
                                    <div class="product-group d-flex align-items-center mb-2">
                                        <div class="col-md-4">
                                            <select class="form-select me-2 selectGrade"
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
                                                value="{{ old('grade_percentage', $tgrade->grade_percentage) }}"
                                                class="form-control me-2 grade-percentage"
                                                placeholder="Target Percentage">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="grade_target_value[{{ $q }}][]"
                                                value="₹{{ number_format($tgrade->grade_target_value, 0) }}"
                                                class="input-as-text grade-target-value" placeholder="₹0" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-grade">Remove
                                                Grade</button>
                                        </div>
                                    </div>
                                    @if ($loop->last)
                                        <!-- Add Grade Button -->
                                        <button type="button" class="btn btn-primary add-grade">Add New
                                            Grade</button>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                @endif

                <div id="quarterlyError" class="text-danger mb-2" style="display:none;"></div>

            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update Target</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('script')
<script>
    $(document).ready(function() {
        updateQuarterOptions();

        /* === Quarterly Calculation === */
        function recalcQuarterlyValues() {
            let mainTarget = parseFloat($('#mainTargetValue').val()) || 0;
            let totalQuarterPercent = 0;

            $('.quarterly-block').each(function() {
                let percentInput = $(this).find('input[name="quarterly_percentage[]"]');
                let percent = parseFloat(percentInput.val()) || 0;
                totalQuarterPercent += percent;

                let targetField = $(this).find('input[name="quarterly_target_value[]"]');
                let quarterlyTarget = 0;

                if (mainTarget > 0 && percent > 0) {
                    quarterlyTarget = (mainTarget * percent) / 100;
                    targetField.val("₹" + quarterlyTarget.toLocaleString());
                } else {
                    targetField.val("₹0");
                }

                // === Grade Calculation per Quarter ===
                recalcGradeValues($(this), quarterlyTarget);
            });

            // === Quarterly Validation ===
            if (totalQuarterPercent > 100) {
                $("#out_of_percentage").show().text("Total Quarterly Percentage cannot exceed 100%.");
            } else {
                $("#out_of_percentage").hide();
            }

            updateQuarterOptions();
        }

        /* === Grade Calculation per Quarter === */
        function recalcGradeValues(quarterBlock, quarterlyTarget) {
            let totalGradePercent = 0;

            quarterBlock.find('.product-group').each(function() {
                let gradePercentInput = $(this).find('.grade-percentage');
                let gradePercent = parseFloat(gradePercentInput.val()) || 0;
                totalGradePercent += gradePercent;

                let gradeTargetField = $(this).find('.grade-target-value');
                if (quarterlyTarget > 0 && gradePercent > 0) {
                    let gradeTarget = (quarterlyTarget * gradePercent) / 100;
                    gradeTargetField.val("₹" + gradeTarget.toLocaleString());
                } else {
                    gradeTargetField.val("₹0");
                }
            });

            // === Grade Validation per Quarter ===
            let gradeErrorContainer = quarterBlock.find('.grade-error');
            if (!gradeErrorContainer.length) {
                gradeErrorContainer = $('<div class="text-danger grade-error mb-2"></div>');
                quarterBlock.find('.grade-section').prepend(gradeErrorContainer);
            }

            if (totalGradePercent > 100) {
                gradeErrorContainer.show().text("Total Grade Percentage cannot exceed 100%.");
            } else {
                gradeErrorContainer.hide();
            }

            // === Apply unique grade option restriction ===
            updateGradeOptions(quarterBlock);
        }

        // === Ensure unique grade selections in a quarter ===
        function updateGradeOptions(quarterBlock) {
            let selectedGrades = [];

            // Collect all selected grade IDs in this quarter
            quarterBlock.find('.selectGrade').each(function() {
                let val = $(this).val();
                if (val) selectedGrades.push(val);
            });

            // Loop through each select and hide already selected options in others
            quarterBlock.find('.selectGrade').each(function() {
                let currentSelect = $(this);
                let currentValue = currentSelect.val();

                currentSelect.find('option').each(function() {
                    let optionVal = $(this).val();

                    if (optionVal && optionVal !== currentValue && selectedGrades.includes(
                            optionVal)) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        }

        /* === Ensure unique quarter selections overall === */
        function updateQuarterOptions() {
            let selectedQuarter = [];

            // Collect all selected grade IDs in this quarter
            $(document).find('.selectQuarter').each(function() {
                let val = $(this).val();
                if (val) selectedQuarter.push(val);
            });
            console.log(selectedQuarter);
            // Loop through each select and hide already selected options in others
            $(document).find('.selectQuarter').each(function() {
                let currentSelect = $(this);
                let currentValue = currentSelect.val();

                currentSelect.find('option').each(function() {
                    let optionVal = $(this).val();

                    if (optionVal && optionVal !== currentValue && selectedQuarter.includes(
                            optionVal)) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        }

        // === Triggers ===
        $(document).on('input',
            '#mainTargetValue, .quarterly-percentage, .grade-percentage',
            function() {
                recalcQuarterlyValues();
            });

        $(document).on('change', '.selectGrade', function() {
            let quarterBlock = $(this).closest('.quarterly-block');
            updateGradeOptions(quarterBlock);
        });

        /* === On Quarter Change === */
        $(document).on('change', '.selectQuarter', function() {
            updateQuarterOptions();
        });

        /* === Add New Quarter === */
        var quarterCount = '{{ $quarterly->count() - 1 ?? 0 }}';
        $(document).on('click', '.add-quarter', function() {
            quarterCount++;
            var qater = `<div class="quarterly-block mb-4 p-3 border rounded">
                    <div class="row align-items-center gap-0 quarterly-row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="col-form-label flex-shrink-0">Quarterly<span
                                        class="text-danger">*</span></label>
                                <select class="form-select me-2 selectQuarter" name="quarterly[]">
                                    <option value="">Select Quarter</option>
                                    <option value="1">Quarterly 1</option>
                                    <option value="2">Quarterly 2</option>
                                    <option value="3">Quarterly 3</option>
                                    <option value="4">Quarterly 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="col-form-label flex-shrink-0">Quarterly Percentage <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="quarterly_percentage[]" 
                                    class="form-control me-2 quarterly-percentage" placeholder="Quarterly Percentage">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center gap-2">
                                <label class="col-form-label flex-shrink-0">Target Value <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="quarterly_target_value[]" 
                                    class="input-as-text quarterly-target-value" placeholder="₹0" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-dark quarter-btn remove-quarter">Remove Quarter</button>
                        </div>
                    </div>

                    <div class="grade-section mt-3">
                        <div class="row fw-bold">
                            <div class="col-md-4">Grade <span class="text-danger">*</span></div>
                            <div class="col-md-3">Target Percentage <span class="text-danger">*</span></div>
                            <div class="col-md-3">Target Value <span class="text-danger">*</span></div>
                        </div>

                        <div class="product-group d-flex align-items-center mb-2">
                            <div class="col-md-4">
                                <select class="form-select me-2 selectGrade" name="grade_id[` + quarterCount + `][]">
                                    <option value="">Select Grade</option>
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
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="grade_percentage[` + quarterCount + `][]"
                                    class="form-control me-2 grade-percentage" placeholder="Target Percentage">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="grade_target_value[` + quarterCount + `][]" 
                                    class="input-as-text grade-target-value" placeholder="₹0" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-grade">Remove Grade</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary add-grade">Add New Grade</button>
                    </div>
                </div>`;
            $(qater).insertAfter('.quarterly-block:last');
            //scroll to new quarter
            $('html, body').animate({
                scrollTop: $(".quarterly-block:last").offset().top
            }, 500);
            //   qater.find('.quarter-btn')
            //     .removeClass('add-quarter btn-danger')
            //     .addClass('remove-quarter btn-dark')
            //     .text('Remove Quarter');
            recalcQuarterlyValues();
            // updateQuarterOptions();

        })

        /* === Remove Quarter === */
        $(document).on('click', '.remove-quarter', function() {
            $(this).closest('.quarterly-block').remove();
            recalcQuarterlyValues();
            // updateQuarterOptions();
        });

        // === Grade Add/Remove ===
        $(document).on('click', '.add-grade', function() {
            let gradeRow = $(this).siblings('.product-group').first().clone();
            gradeRow.find('input, select').val('');
            $(this).before(gradeRow);

            let quarterBlock = $(this).closest('.quarterly-block');
            updateGradeOptions(quarterBlock);
        });

        /* === Remove Grade === */
        $(document).on('click', '.remove-grade', function() {
            let gradeSection = $(this).closest('.grade-section');
            let quarterBlock = $(this).closest('.quarterly-block');
            console.log(gradeSection.find('.product-group').length);
            if (gradeSection.find('.product-group').length > 1) {
                $(this).closest('.product-group').remove();
                recalcQuarterlyValues();
                updateGradeOptions(quarterBlock);
            } else {
                alert("At least one grade is required.");
            }
        });

    });


    // === Form Submit Validation (Main + Quarterly) ===
    $("form").on("submit", function(e) {
        let valid = true;
        let totalQuarterPercent = 0;
        $("#quarterlyError").hide().text("");

        // ---- Remove old errors ----
        $(".field-error").remove();
        $(".quarterly-error").remove();

        // ---- Validate Main Fields ----
        let subject = $('input[name="subject"]');
        let salesman = $('select[name="salesman_id"], input[name="salesman_id"][type="hidden"]');
        let city = $('select[name="city_id"]');
        let targetValue = $('input[name="target_value"]');

        if (!subject.val().trim()) {
            valid = false;
            subject.after('<div class="text-danger field-error">Target Name is required.</div>');
        }

        if (!salesman.val().trim()) {
            valid = false;
            salesman.closest('.mb-3').append(
                '<div class="text-danger field-error">Sales Person is required.</div>');
        }

        if (!city.val().trim()) {
            valid = false;
            city.closest('.mb-3').append('<div class="text-danger field-error">Region is required.</div>');
        }

        if (!targetValue.val().trim()) {
            valid = false;
            targetValue.after('<div class="text-danger field-error">Target Value is required.</div>');
        }

        // ---- Validate Quarterly Blocks ----
        $(".quarterly-block").each(function(index) {
            let quarterBlock = $(this);
            let blockValid = true;
            let totalGradePercent = 0;
            let quarterSelect = quarterBlock.find('select[name="quarterly[]"]');
            let quarterPercent = quarterBlock.find('input[name="quarterly_percentage[]"]');

            if (!quarterSelect.val() || !quarterPercent.val()) {
                blockValid = false;
            }

            let percent = parseFloat(quarterPercent.val()) || 0;
            totalQuarterPercent += percent;
            if (totalQuarterPercent > 100) {
                blockValid = false;
                valid = false;
                return false; // break
            }


            quarterBlock.find(".product-group").each(function() {
                let gradeSelect = $(this).find('.selectGrade');
                let gradePercent = $(this).find('.grade-percentage');
                if (!gradeSelect.val() || !gradePercent.val()) {
                    blockValid = false;
                    return false; // break
                }
                totalGradePercent += parseFloat(gradePercent.val()) || 0;

            });

            if (totalGradePercent > 100) {
                blockValid = false;
                valid = false;
                return false; // break
            }

            if (!blockValid) {
                valid = false;
                quarterBlock.prepend(
                    '<div class="text-danger quarterly-error mb-2">⚠ All fields are required in this Quarterly section (Quarter ' +
                    (index + 1) + ').</div>'
                );
            }
        });

        if (!valid) {
            e.preventDefault();
            $("#quarterlyError").show().text("Some required fields are missing. Please check.");
        }
    });
</script>
@endsection
