@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <form action="{{ route('order_management.store') }}" id="orderForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4 order-form">
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Order ID</label>
                    <input type="text" name="unique_order_id" value="{{ $unique_order_id }}" class="form-control"
                        readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Firm Name <span class="text-danger">*</span></label>
                    <select name="dd_id" class="form-control form-select search-dropdown">
                        <option value="">Select</option>
                        @if ($distributor_dealers)
                            @foreach ($distributor_dealers as $dd)
                                <option value="{{ $dd->id }}" {{ old('dd_id') == $dd->id ? 'selected' : '' }}
                                    data-user_type="{{ $dd->user_type }}" data-mobile_no="{{ $dd->mobile_no }}"
                                    data-gst_no="{{ $dd->gstin }}" data-pancard="{{ $dd->pancard }}"
                                    data-address="{{ $dd->firm_shop_address }}"
                                    data-salesperson_id="{{ $dd->sales_person_id }}">
                                    {{ $dd->firm_shop_name }}
                                    {{ $dd->user_type == 1 ? '(Distributor)' : ($dd->user_type == 2 ? '(Dealers)' : '') }}
                                    - {{ $dd->city->city_name ?? '' }}
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
                    <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control"
                        placeholder="Phone" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                        readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Salesman <span class="text-danger">*</span></label>
                    @if (auth()->user()->hasRole('sales'))
                        <input type="text" value="{{ auth()->user()->name }}" id="sales_person_name"
                            class="form-control" readonly>
                        <input type="hidden" name="salesman_id" value="{{ auth()->user()->id }}">
                    @else
                        <select name="salesman_id" class="form-control form-select search-dropdown" id="salesmanId">
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
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Transport <span class="text-danger">*</span></label>
                    <input type="text" name="transport" value="{{ old('transport') }}" class="form-control"
                        placeholder="Transport" maxlength="255">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Freight <span class="text-danger">*</span></label>
                    <input type="text" name="freight" value="{{ old('freight') }}" class="form-control"
                        placeholder="Freight" maxlength="255">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">GST No. </label>
                    <input type="text" name="gst_no" value="{{ old('gst_no') }}" class="form-control"
                        placeholder="GST No" maxlength="255" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Pan Card No.</label>
                    <input type="text" name="pancard" value="{{ old('pancard') }}" class="form-control"
                        placeholder="Pan Card No" maxlength="255" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="address" placeholder="Address" readonly>{{ old('address') }}</textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label d-block">Advance Payment Discount </label>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="advance_payment_discount" value="no">
                        <input class="form-check-input advance-payment-discount" type="checkbox"
                            name="advance_payment_discount" id="advance_payment_discount" value="yes">
                        <label class="form-check-label" for="advance_payment_discount">Advance Payment
                            Discount
                            ({{ getSetting('advance_payment_discount') }}{{ getSetting('discount_type') == 'rupees' ? '₹' : '%' }})

                        </label>
                    </div>
                    <input type="hidden" name="payment_discount"
                        value="{{ getSetting('advance_payment_discount') }}">
                    <input type="hidden" name="discount_type" value="{{ getSetting('discount_type') }}">
                    <!-- Image Field -->
                </div>
                <div class="col-md-4 mb-3 advance-payment-discount-image-field" style="display: none;">
                    <label class="col-form-label"> Upload Image <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="advance_pay_discount_img" accept="image/*">
                </div>
            </div>
            <input type="hidden" name="dummy" id="dummyValidationField" />

            <div class="table-responsive gc-order-management-table">
                <table class="table table-view addnewfield">
                    <thead>
                        <tr>
                            <th scope="col">S.No </th>
                            <th scope="col">Product Name <span class="text-danger">*</span></th>
                            <th scope="col">GST(%)</th>
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
                                        <option value="{{ $product->id }}" data-gst="{{ $product->gst }}">
                                            {{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-label="GST">
                                <input type="number" name="gst[]" value="" class="form-control gst-field"
                                    readonly placeholder="GST">
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
                    <input type="hidden" name="total_order_amount" value="">
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label" id="all_total">Total : 0</label>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label">GST {{ getSetting('gst') }}% : <span
                                    id="gstAmount">0</span></label>
                            <input type="hidden" name="gst" value="{{ getSetting('gst') }}">
                            <input type="hidden" name="gst_amount" value="">
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label" id="product_total_order_amount">Total Amount : 0 </label>
                            <label class="col-form-label" id="discount">Discount : 0 </label>
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
    $(document).ready(function() {
        advancePaymentDiscount();

        //  checkbox On change
        $(document).on('change', '.transport-option', function() {
            toggleTransportFields();
        });

        /*** advance payment discount checked or not***/
        function advancePaymentDiscount() {
            const advancePaymentDiscount = $('input[name="advance_payment_discount"]:checked').val();
            if (advancePaymentDiscount === 'yes') {
                $('.advance-payment-discount-image-field').show();
            } else {
                $('.advance-payment-discount-image-field').hide();
            }
        }
        $(document).on('change', '.advance-payment-discount', function() {
            advancePaymentDiscount();
            calculateGrandTotal();
        })
    });

    /*** party name select and phone number|gst|address|pancard auto fillable ***/
    $(function() {
        $('[name="dd_id"]').change(function() {
            let selected = $(this).find('option:selected');
            // let salesPersonId = selected.data('salesPersonId');

            $('[name="mobile_no"]').val(selected.data('mobile_no') || '');
            $('[name="gst_no"]').val(selected.data('gst_no') || '');
            $('[name="pancard"]').val(selected.data('pancard') || '');
            $('[name="address"]').val(selected.data('address') || '');
            // console.log(selected.data('salesperson_id'));
            var salsmen_id = selected.data('salesperson_id');
            $('#salesmanId').val(salsmen_id).trigger('change');
            // $('#sales_person_name').val(selected.data('salesmanId') || '');
            // console.log($('#sales_person_name').val(selected.data('salesmanId') || ''));
            // $('#salesmanId').val(selected.data('salesperson_id')).select2().trigger('change');
        });
    });


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
                // gst_no: {
                //     required: true
                // },
                address: {
                    required: true
                },
                dummy: {
                    validateProducts: true
                },
                advance_payment_discount: {
                    required: false,
                },
                advance_pay_discount_img: {
                    required: function() {
                        // Check if "Outside Company Transport" selected
                        const isYes = $('input[name="advance_payment_discount"]:checked')
                            .val() ===
                            'yes';

                        // Check if an existing LR file is present (we’ll store it in a hidden input)
                        const existingImg = $('input[name="existing_advance_pay_discount_img"]')
                            .val();

                        // Require only if "outside" AND no existing file
                        return isYes && !existingImg;

                        // return $('input[name="advance_payment_discount"]:checked').val() === 'outside';
                    },
                }

            },
            messages: {
                dd_id: "Please select firm name",
                order_date: "Please enter a valid order date",
                mobile_no: {
                    required: "Please enter mobile number",
                    digits: "Only digits allowed",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must be 10 digits"
                },
                salesman_id: "Please select salesman name",
                transport: "Please enter transport details",
                freight: "Please enter freight value",
                // gst_no: "Please enter GST number",
                address: "Please enter address",
                advance_payment_discount: "Please select advance payment discount",
                advance_pay_discount_img: "Please upload image",
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
                                     <option value="{{ $product->id }}" data-gst="{{ $product->gst }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-label="GST">
                               <input type="number" name="gst[]" value="" class="form-control gst-field" readonly placeholder="GST">
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

        var gst = $(this).find("option:selected").data("gst");
        $(this).closest("tr").find('input[name="gst[]"]').val(gst);

        $(this).closest('.field-group').find('[name="price[]"]').val('');
        let selectedProductID = $(this).val();
        let sizeDropdown = $(this).closest('.field-group').find('select[name="packing_size_id[]"]');

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
                        // console.log('yes');
                        // console.log(response);
                        let sizeOptions = '<option value="">Select</option>';

                        $.each(response.product_variation, function(index, product_variation) {
                            if (product_variation.variation_option_value) {
                                let val = product_variation.variation_option_value;
                                sizeOptions +=
                                    `<option value="${val.id}">${val.value} ${val.unit}</option>`; //${val.unit}
                            }
                        });

                        // console.log(sizeOptions);

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

    $('#advance_payment_discount').on('change', function() {
        if ($(this).is(':checked')) {
            $('input[name="payment_discount"]').val(getSetting('discount_type')); // or whatever value you want

        } else {
            $('input[name="payment_discount"]').val(0);
        }
        calculateGrandTotal()
    });
    // Calculate Grand Total
    function calculateGrandTotal() {
        $('[name="price[]"]').each(function() {
            let price = parseFloat($(this).val()) || 0;
            let qty = parseFloat($(this).closest('.field-group').find('input[name="qty[]"]').val()) || 0;
            let gst = parseFloat($(this).closest('.field-group').find('input[name="gst[]"]').val()) || 0;
            let with_gst = price * (gst / 100);
            price = price + with_gst;
            $(this).closest('.field-group').find('input[name="total[]"]').val((price * qty).toFixed(2));
        });

        let all_total = 0;
        // let gst = parseFloat('{{ getSetting('gst') }}') || 0;

        $('[name="total[]"]').each(function() {
            let val = parseFloat($(this).val()) || 0;
            all_total += val;
        });

        let gstAmount = 0;
        let grandTotal = all_total;
        let product_total_order_amount = all_total;
        // $('#all_total').text('Total : ' + IndianNumberFormatscript(all_total.toFixed(0)));
        // $('#gstAmount').text(IndianNumberFormatscript(gstAmount.toFixed(0)));


        // ✅ CHECK CHECKBOX STATUS
        let isAdvanceChecked = $('#advance_payment_discount').is(':checked');
        if (isAdvanceChecked) {
            let paymentDiscount = parseFloat($('input[name="payment_discount"]').val()) || 0;
            let discountType = $('input[name="discount_type"]').val(); // rupees / percentage
            let discountAmount = 0;

            if (discountType === 'rupees') {
                discountAmount = paymentDiscount;
            } else if (discountType === 'percentage') {
                discountAmount = (grandTotal * paymentDiscount) / 100;
            }
            grandTotal = Math.max(0, grandTotal - discountAmount);

            let sign = discountType === 'rupees' ? '₹' : '%';
            $('#discount').text(
                'Discount : ' +
                (sign === '₹' ?
                    sign + paymentDiscount :
                    paymentDiscount + sign)
            );
        } else {
            $('#discount').text('Discount : 0');
        }

        $('#product_total_order_amount').text('Total Amount : ₹' + all_total.toFixed(2));
        $('#grand_total').text('Grand Total (Incl. GST) : ₹' + grandTotal.toFixed(2));
        $('input[name="total_order_amount"]').val(all_total.toFixed(2));
        $('input[name="gst_amount"]').val(gstAmount.toFixed(0));
        $('input[name="grand_total"]').val(grandTotal.toFixed(2));
    }
</script>

{{-- old validation --}}
<script>
    // $(document).on('change', 'selcet[name="packing_size_id[]"]', function() {
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
