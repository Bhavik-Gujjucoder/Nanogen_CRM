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

        .quarterly-block {
            margin-bottom: 20px;
            /* space between blocks */
            padding: 15px;
            /* inner spacing */
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .grade-section .row.fw-bold {
            /* border-bottom: 2px solid #ddd; */
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
    </style>
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form action="{{ route('target.store') }}" id="target_form" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Target Name <span class="text-danger">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"
                            placeholder="Target Name" maxlength="255">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="col-form-label">Sales Person Name <span class="text-danger">*</span></label>
                        @if (auth()->user()->hasRole('sales'))
                            {{-- <!--  <input type="text" value="{{ auth()->user()->name }}" class="form-control" readonly>
                            <input type="hidden" name="salesman_id" value="{{ auth()->user()->id }}"> --> --}}

                            <select name="salesman_id" class="form-control form-select search-dropdown">
                                <option value="">Select</option>
                                @if ($reportingUserId->isNotEmpty())
                                    @foreach ($reportingUserId as $rs)
                                        <option value="{{ $rs->user_id }}"
                                            {{ old('salesman_id') == $rs->user_id ? 'selected' : '' }}>
                                            {{ $rs->first_name }} {{ $rs->last_name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No record</option>
                                @endif
                            </select>
                        @else
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
                        <input type="number" name="target_value" id="mainTargetValue"
                            value="{{ old('target_value') }}" class="form-control" placeholder="Target Value">
                    </div>
                </div>

                <!-- Wrap a full quarterly + grade block -->
                <div id="out_of_percentage" class="text-danger mb-2" style="display:block;"></div>
                <div class="quarterly-block mb-4 p-3 border rounded">
                    <div class="row align-items-center gap-0 quarterly-row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="col-form-label flex-shrink-0">Quarterly <span
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
                            <button type="button" class="btn btn-danger quarter-btn add-quarter">Add New
                                Quarter</button>
                        </div>
                    </div>

                    <!-- Grade Section -->
                    <div class="grade-section mt-3">
                        <!-- Grade Heading -->
                        <div class="row fw-bold">
                            <div class="col-md-4">Grade <span class="text-danger">*</span></div>
                            <div class="col-md-3">Target Percentage <span class="text-danger">*</span></div>
                            <div class="col-md-3">Target Value <span class="text-danger">*</span></div>
                        </div>

                        <!-- Grade Row -->
                        <div class="product-group d-flex align-items-center mb-2">
                            <div class="col-md-4">
                                <select class="form-select me-2 selectGrade" name="grade_id[0][]">
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
                                <input type="number" name="grade_percentage[0][]"
                                    value="{{ old('grade_percentage') }}" class="form-control me-2 grade-percentage"
                                    placeholder="Target Percentage">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="grade_target_value[0][]"
                                    class="input-as-text grade-target-value" placeholder="₹0" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-grade">Remove Grade</button>
                            </div>
                        </div>

                        <!-- Add Grade Button -->
                        <button type="button" class="btn btn-primary add-grade">Add New Grade</button>
                    </div>
                </div>
                <div id="quarterlyError" class="text-danger mb-2" style="display:none;"></div>

            </div>
            <div class="d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('script')
<script>
    $(document).ready(function() {
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

        /* === On Grade Change === */
        $(document).on('change', '.selectGrade', function() {
            let quarterBlock = $(this).closest('.quarterly-block');
            updateGradeOptions(quarterBlock);
        });

        /* === On Quarter Change === */
        $(document).on('change', '.selectQuarter', function() {
            updateQuarterOptions();
        });
        // === Quarter Add/Remove ===
        // $(document).on('click', '.add-quarter', function() {
        //     let currentQuarter = $(this).closest('.quarterly-block');
        //     let clone = currentQuarter.clone(true);

        //     // reset inputs in cloned block
        //     clone.find('input, select').val('');
        //     clone.find('.grade-error').remove();

        //     // keep only the first grade row
        //     let firstGrade = clone.find('.product-group').first().clone();
        //     firstGrade.find('input, select').val('');
        //     clone.find('.product-group').remove(); // remove all grade rows
        //     clone.find('.add-grade').before(firstGrade); // add back only one row

        //     // change current button to "remove"
        //     currentQuarter.find('.quarter-btn')
        //         .removeClass('add-quarter btn-danger')
        //         .addClass('remove-quarter btn-dark')
        //         .text('Remove Quarter');

        //     // insert new block
        //     $('.quarterly-block').first().before(clone);
        //     recalcQuarterlyValues();
        // });

        /* === Add New Quarter === */
        var quarterCount = 0;
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

        })

        /* === Remove Quarter === */
        $(document).on('click', '.remove-quarter', function() {
            $(this).closest('.quarterly-block').remove();
            recalcQuarterlyValues();
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

        // alert(valid);

        if (!valid) {
            e.preventDefault();
            $("#quarterlyError").show().text("Some required fields are missing. Please check.");
        }
    });

    // === Auto Hide Error When Field Filled ===
    // $(document).on("input change",
    //     'input[name="subject"], select[name="salesman_id"], select[name="city_id"], input[name="target_value"], input[name="quarterly_percentage[]"], input[name="grade_percentage[]"], select[name="quarterly[]"], select[name="grade_id[]"]',
    //     function() {
    //         let input = $(this);

    //         // Remove field-level error if filled
    //         if (input.val().trim()) {
    //             input.closest('.mb-3').find(".field-error").remove();
    //             input.closest('.col-md-4').find(".field-error").remove();
    //         }

    //         // Re-check quarterly block validity
    //         let quarterBlock = input.closest(".quarterly-block");
    //         if (quarterBlock.length) {
    //             let blockValid = true;
    //             let quarterSelect = quarterBlock.find('select[name="quarterly[]"]');
    //             let quarterPercent = quarterBlock.find('input[name="quarterly_percentage[]"]');

    //             if (!quarterSelect.val() || !quarterPercent.val()) {
    //                 blockValid = false;
    //             }

    //             quarterBlock.find(".product-group").each(function() {
    //                 let gradeSelect = $(this).find('select[name="grade_id[]"]');
    //                 let gradePercent = $(this).find('input[name="grade_percentage[]"]');
    //                 if (!gradeSelect.val() || !gradePercent.val()) {
    //                     blockValid = false;
    //                     return false;
    //                 }
    //             });

    //             if (blockValid) {
    //                 quarterBlock.find(".quarterly-error").remove();
    //             }
    //         }
    //     }
    // );
</script>


{{-- <script>
    $(document).ready(function() {
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
        }

        function recalcGradeValues(quarterBlock, quarterlyTarget) {
            let totalGradePercent = 0;

            quarterBlock.find('.product-group').each(function() {
                let gradePercentInput = $(this).find('input[name="grade_percentage[]"]');
                let gradePercent = parseFloat(gradePercentInput.val()) || 0;
                totalGradePercent += gradePercent;

                let gradeTargetField = $(this).find('input[name="grade_target_value[]"]');
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
            quarterBlock.find('select[name="grade_id[]"]').each(function() {
                let val = $(this).val();
                if (val) selectedGrades.push(val);
            });

            // Loop through each select and hide already selected options in others
            quarterBlock.find('select[name="grade_id[]"]').each(function() {
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

        // === Triggers ===
        $(document).on('input',
            '#mainTargetValue, input[name="quarterly_percentage[]"], input[name="grade_percentage[]"]',
            function() {
                recalcQuarterlyValues();
            });

        $(document).on('change', 'select[name="grade_id[]"]', function() {
            let quarterBlock = $(this).closest('.quarterly-block');
            updateGradeOptions(quarterBlock);
        });

        // === Quarter Add/Remove ===
        $(document).on('click', '.add-quarter', function() {
            let currentQuarter = $(this).closest('.quarterly-block');
            let clone = currentQuarter.clone(true);

            // reset inputs in cloned block
            clone.find('input, select').val('');
            clone.find('.grade-error').remove();

            // change current button to "remove"
            currentQuarter.find('.quarter-btn')
                .removeClass('add-quarter btn-danger')
                .addClass('remove-quarter btn-dark')
                .text('Remove Quarter');

            // insert new block
            $('.quarterly-block').first().before(clone);
            recalcQuarterlyValues();
        });

        $(document).on('click', '.remove-quarter', function() {
            $(this).closest('.quarterly-block').remove();
            recalcQuarterlyValues();
        });

        // === Grade Add/Remove ===
        $(document).on('click', '.add-grade', function() {
            let gradeRow = $(this).siblings('.product-group').first().clone();
            gradeRow.find('input, select').val('');
            $(this).before(gradeRow);

            let quarterBlock = $(this).closest('.quarterly-block');
            updateGradeOptions(quarterBlock);
        });

        $(document).on('click', '.remove-grade', function() {
            let gradeSection = $(this).closest('.grade-section');
            let quarterBlock = $(this).closest('.quarterly-block');

            if (gradeSection.find('.product-group').length > 1) {
                $(this).closest('.product-group').remove();
                recalcQuarterlyValues();
                updateGradeOptions(quarterBlock);
            } else {
                alert("At least one grade is required.");
            }
        });

    });
</script> --}}
@endsection
