@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form action="{{ route('order_management.store') }}" id="orderForm" method="POST">
            @csrf
            <div class="row mb-4 order-form">

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Order ID</label>
                    <input type="text" name="unique_order_id" value="{{ $unique_order_id }}" class="form-control"
                        readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Party Name <span class="text-danger">*</span></label>
                    <select name="dd_id" class="form-control form-select search-dropdown">
                        <option value="">Select</option>
                        @if ($distributor_dealers)
                            @foreach ($distributor_dealers as $dd)
                                <option value="{{ $dd->id }}" {{ old('dd_id') == $dd->id ? 'selected' : '' }}
                                    data-user_type="{{ $dd->user_type }}">
                                    {{ $dd->applicant_name }}
                                    {{ $dd->user_type == 1 ? '(Distributor)' : ($dd->user_type == 2 ? '(Dealers)' : '') }}
                                </option>
                            @endforeach
                        @else
                            <option value="">No record</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Order Date <span class="text-danger">*</span></label>
                    <div class="icon-form">
                        <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                        <input type="text" name="order_date" value="{{ old('order_date') }}" id="datePicker"
                            class="form-control" placeholder="Order Date">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                    <input type="number" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control"
                        placeholder="1234567890">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Salesman <span class="text-danger">*</span></label>
                    {{-- @if (auth()->user()->hasRole('sales'))
                        <input type="text"  value="{{ auth()->user()->name }}" class="form-control" readonly>
                        <input type="hidden" name="salesman_id" value="{{ auth()->user()->id }}" > 
                    @else --}}
                    @if (auth()->user()->hasRole('sales'))
                        <select name="salesman_id" class="form-control">
                            <option value="{{ auth()->user()->id }}" selected readonly>{{ auth()->user()->name }}</option>
                        </select>
                    @else
                        <select name="salesman_id" class="form-control form-select search-dropdown">
                            <option value="">Select</option>
                            @if ($salesmans)
                                @foreach ($salesmans as $s)
                                    <option value="{{ $s->id }}"
                                        {{ old('salesman_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->first_name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">No record</option>
                            @endif
                        </select>
                    @endif
                    {{-- @endif --}}
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Transport <span class="text-danger">*</span></label>
                    <input type="text" name="transport" value="{{ old('transport') }}" class="form-control"
                        placeholder="Transport">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Freight <span class="text-danger">*</span></label>
                    <input type="text" name="freight" value="{{ old('freight') }}" class="form-control"
                        placeholder="Freight">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">GST No. <span class="text-danger">*</span></label>
                    <input type="text" name="gst_no" value="{{ old('gst_no') }}" class="form-control"
                        placeholder="GST No">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="address" placeholder="Address">{{ old('address') }}</textarea>
                </div>
            </div>
            <input type="hidden" name="dummy" id="dummyValidationField" />

            <div class="table-responsive">
                <table class="table table-view addnewfield">
                    <thead>
                        <tr>
                            <th scope="col">S.No </th>
                            <th scope="col">Product Name <span class="text-danger">*</span></th>
                            <th scope="col">Packing Size <span class="text-danger">*</span></th>
                            <th scope="col">Price <span class="text-danger">*</span></th>
                            <th scope="col">QTY <span class="text-danger">*</span></th>
                            <th scope="col">Total <span class="text-danger">*</span></th>
                            <th scope="col">Action </th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <tr class="field-group">
                            <td data-label="S.No.">1</td>
                            <td data-label="Product Name">
                                <select name="product_id[]"
                                    class="form-control product-field form-select product_id-field search-dropdown">
                                    <option selected disabled>Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-label="Packing Size">
                                <select name="packing_size_id[]"
                                    class="form-control form-select product-field packing_size_field search-dropdown">
                                    <option selected disabled>Select</option>
                                </select>
                            </td>
                            <td data-label="Price">
                                <input type="number" name="price[]" value="{{ old('price') }}" readonly
                                    class="form-control product-field price-field" placeholder="Price">
                            </td>
                            <td data-label="QTY">
                                <input type="number" name="qty[]" value="{{ old('qty') }}"
                                    class="form-control product-field qty-field" placeholder="QTY">
                            </td>
                            <td data-label="Total">
                                <input type="number" name="total[]" class="form-control total-field" readonly
                                    placeholder="Total">
                            </td>
                            <td data-label="Action">
                                <button type="button" onclick="addpropRow()" class="btn btn-primary">Add
                                    New</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="productError" class="text-danger mb-3" style="display:none;">
                    Please fill all fields in each product row.
                </div>
            </div>
            <div class="gstsec mt-4 mb-4">
                <div class="totalsec text-end">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label" id="all_total">Total : 0</label>
                            <input type="hidden" name="total_order_amount" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label">GST {{ getSetting('gst') }}% : <span
                                    id="gstAmount">0</span></label>
                            <input type="hidden" name="gst" value="{{ getSetting('gst') }}">
                            <input type="hidden" name="gst_amount" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label" id="grand_total">Grand Total (Incl. GST) : 0</label>
                            <input type="hidden" name="grand_total" value="">
                        </div>
                    </div>
                </div>
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

    /*** validation  ***/
    $(document).ready(function() {
        $.validator.addMethod("validateProducts", function(value, element) {
            let isValid = true;

            $(".field-group").each(function() {
                let product = $(this).find(".product_id-field").val();
                let price = $(this).find(".price-field").val();
                let qty = $(this).find(".qty-field").val();
                let packing = $(this).find(".packing_size_field").val();
                let total = $(this).find(".total-field").val();

                if (
                    product === "" || product === "Select" ||
                    price.trim() === "" ||
                    qty.trim() === "" ||
                    packing === "" || packing === "Select" ||
                    total.trim() === ""
                ) {
                    isValid = false;
                    return false; // Break loop
                }
            });

            return isValid;
        }, "Please fill all fields in each product row.");

        $("#orderForm").validate({
            ignore: [],
            rules: {
                dd_id: {
                    required: true
                },
                order_date: {
                    required: true,
                    // date: true
                },
                mobile_no: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                salesman_id: {
                    required: true
                },
                transport: {
                    required: true
                },
                freight: {
                    required: true
                },
                gst_no: {
                    required: true
                },
                address: {
                    required: true
                },
                dummy: {
                    validateProducts: true
                }
            },
            messages: {
                dd_id: "Please enter party name",
                order_date: "Please enter a valid order date",
                mobile_no: {
                    required: "Please enter mobile number",
                    digits: "Only digits allowed",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must be 10 digits"
                },
                salesman_id: "Please enter salesman name",
                transport: "Please enter transport details",
                freight: "Please enter freight value",
                gst_no: "Please enter GST number",
                address: "Please enter address"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                if (element.attr("name") === "dummy") {
                    $("#productError").text(error.text()).show();
                } else if (element.hasClass('select2-hidden-accessible')) {
                    error.addClass('text-danger');
                    error.insertAfter(element.next(
                        '.select2')); // This targets the Select2 container
                } else {
                    error.addClass('text-danger');
                    error.insertAfter(element);
                }
            },
            success: function(label, element) {
                if ($(element).attr("name") === "dummy") {
                    $("#productError").hide();
                }
            }
        });

    });
    /*** END ***/
</script>

<script>
    /*** Add product ***/
    function addpropRow() {
        let tableBody = $("#table-body");
        let newIndex = $(".field-group").length + 1;

        // Remove existing "Add New" button before adding a new row
        $(".field-group:last td:last").html(
            '<button type="button" onclick="removeRow(this)" class="btn btn-danger">Remove</button>');

        let newRow = `<tr class="field-group">
                            <td data-label="S.No.">${newIndex}</td>
                            <td data-label="Product Name">
                                <select name="product_id[]" class="form-control product-field form-select product_id-field search-dropdown">
                                    <option selected>Select</option>
                                    @foreach ($products as $product)
                                     <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                             <td data-label="Packing Size">
                                <select name="packing_size_id[]" class="form-control form-select product-field packing_size_field search-dropdown">
                                    <option selected>Select</option>
                                </select>
                            </td>
                            <td data-label="Price">
                                <input type="number" name="price[]" value="{{ old('price') }}" readonly class="form-control product-field price-field"
                                    placeholder="Price">
                            </td>
                            <td data-label="QTY">
                                <input type="number" name="qty[]" value="{{ old('qty') }}" class="form-control product-field qty-field"
                                    placeholder="QTY">
                            </td>
                           
                            <td data-label="Total">
                                <input type="number" name="total[]" class="form-control total-field" readonly placeholder="Total">
                            </td>
                            <td data-label="Action">
                                <button type="button" onclick="addpropRow()" class="btn btn-primary">Add New</button>
                            </td>
                        </tr>`;

        tableBody.append(newRow);
        $('.search-dropdown').select2({
            placeholder: "Select"
        });
    }
    /*** END ***/

    /*** Row Remove ***/
    function removeRow(button) {
        $(button).closest("tr").remove();
        updateSerialNumbers();
        calculateGrandTotal();
    }
    /*** END ***/

    /*** Serial Number count update ***/
    function updateSerialNumbers() {
        $(".field-group").each(function(index) {
            $(this).find("td:first").text(index + 1);
        });
    }
    /*** END ***/

    /*** product name wise get packing-size ***/
    $(document).on('change', 'select[name="product_id[]"]', function() {
        $(this).closest('.field-group').find('[name="price[]"]').val('');
        let selectedProductID = $(this).val();
        let sizeDropdown = $(this).closest('.field-group').find(
            'select[name="packing_size_id[]"]');

        if (selectedProductID) {
            $.ajax({
                url: "{{ route('product.variation.get') }}", // Laravel route for fetching sizes
                type: "POST",
                data: {
                    product_id: selectedProductID,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        let sizeOptions = '<option value="">Select</option>';
                        $.each(response.product_variation, function(index, product_variation) {
                            sizeOptions +=
                                `<option value="${product_variation.variation_option_value.id}">${product_variation.variation_option_value.value}</option>`;
                        });

                        // Only replace the options, keep the existing dropdown
                        sizeDropdown.html(sizeOptions);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
    /*** END ***/
</script>

<script>
    /*** Calculate Fully update ***/
    $(document).ready(function() {
        calculateGrandTotal(); // Initial total on load for edit

        $(document).on('change', 'select[name="dd_id"]', function() {
            $('select[name="packing_size_id[]"]').trigger('change');
        });

        /*** On qty input change totol ***/
        $('body').on('input', '.qty-field', function() {
            calculateGrandTotal();
        });

        /*** On packing size change (fetch and update price) ***/
        $(document).on('change', 'select[name="packing_size_id[]"]', function() {
            let product_id = $(this).closest('.field-group').find('select[name="product_id[]"]').val();
            let selectedVariationOptionID = $(this).val();
            let priceField = $(this).closest('.field-group').find('[name="price[]"]');
            let qty_field = $(this).closest('.field-group').find('[name="qty[]"]');
            let user_type = $('select[name="dd_id"] option:selected').data('user_type');

            if (selectedVariationOptionID) {
                $.ajax({
                    url: "{{ route('product.variation.price.get') }}",
                    type: "POST",
                    data: {
                        variation_option_id: selectedVariationOptionID,
                        product_id: product_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (user_type == 1) {
                                priceField.val(response.product.distributor_price);
                            } else {
                                priceField.val(response.product.dealer_price);
                            }
                            calculateGrandTotal(); // Trigger total + grand total
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });

    // Calculate Grand Total
    function calculateGrandTotal() {
        $('[name="price[]"]').each(function() {
            let price = parseFloat($(this).val()) || 0;
            let qty = parseFloat($(this).closest('.field-group').find('input[name="qty[]"]')
                .val()) || 0;
            $(this).closest('.field-group').find('input[name="total[]"]').val((price * qty).toFixed(
                0));
        });

        let all_total = 0;
        let gst = parseFloat('{{ getSetting('gst') }}') || 0;

        $('[name="total[]"]').each(function() {
            let val = parseFloat($(this).val()) || 0;
            all_total += val;
        });

        let gstAmount = (all_total * gst) / 100;
        let grandTotal = all_total + gstAmount;

        $('#all_total').text('Total : ' + all_total.toFixed(2));
        $('#gstAmount').text(gstAmount.toFixed(2));
        $('#grand_total').text('Grand Total (Incl. GST) : ' + grandTotal.toFixed(2));

        $('input[name="total_order_amount"]').val(all_total.toFixed(0));
        $('input[name="gst_amount"]').val(gstAmount.toFixed(0));
        $('input[name="grand_total"]').val(grandTotal.toFixed(0));
    }
</script>

{{-- old validation --}}
<script>
    // $(document).on('change', 'select[name="packing_size_id[]"]', function() {
    //     let product_id = $(this).closest('.field-group').find('select[name="product_id[]"]').val();
    //     let selectedVariationOptionID = $(this).val();
    //     let priceField = $(this).closest('.field-group').find('[name="price[]"]');
    //     let user_type = $('select[name="dd_id"] option:selected').data('user_type'); //attr('data-user_type') 

    //     if (selectedVariationOptionID) {
    //         $.ajax({
    //             url: "{{ route('product.variation.price.get') }}",
    //             type: "POST",
    //             data: {
    //                 variation_option_id: selectedVariationOptionID,
    //                 product_id: product_id,
    //                 _token: '{{ csrf_token() }}'
    //             },
    //             success: function(response) {
    //                 if (response.success) {
    //                     if (user_type == 1) { //distibutor price
    //                         priceField.val(response.product.distributor_price);
    //                     } else { //dealer price
    //                         priceField.val(response.product.dealer_price);
    //                     }
    //                 }
    //             },
    //             error: function(xhr) {
    //                 console.log(xhr.responseText);
    //             }
    //         });
    //     }
    // });
    // $('body').on('input', '.qty-field', function() {
    //     let group = $(this).closest('.field-group');
    //     let price = +group.find('.price-field').val() || 0;
    //     let qty = +group.find('.qty-field').val() || 0;
    //     group.find('[name="total[]"]').val((price * qty).toFixed(0));
    //     calculateGrandTotal(); // Call to update grand total
    // });
    // function calculateGrandTotal() {
    //     let all_total = 0;
    //     let gst = parseFloat('{{ getSetting('gst') }}') || 0;
    //     $('[name="total[]"]').each(function() {
    //         let val = parseFloat($(this).val()) || 0;
    //         all_total += val;
    //     });


    //     // Example: show total in an element with id="grandTotal"
    //     $('#all_total').text('Total : ' + all_total.toFixed(2));

    //     let gstAmount = (all_total * gst) / 100;
    //     let grandTotal = all_total + gstAmount;
    //     $('#gstAmount').text(gstAmount.toFixed(2));
    //     $('#grand_total').text('Grand Total (Incl. GST) : ' + grandTotal.toFixed(2));

    //     $('input[name="total_order_amount"]').val(all_total.toFixed(0));
    //     $('input[name="gst_amount"]').val(gstAmount.toFixed(0));
    //     $('input[name="grand_total"]').val(grandTotal.toFixed(0));
    // }
</script>
@endsection
