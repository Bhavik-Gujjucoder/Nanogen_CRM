@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection


<div class="card">
    <div class="card-body">
        <div class="prodctmain">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-pic-upload">
                            <div class="profile-pic">
                                {{-- <span><i class="ti ti-photo"></i></span> --}}
                                <img id="profilePreview" src="{{ asset('images/default-user.png') }}"
                                    alt="Profile Picture" class="img-thumbnail mb-2">
                            </div>
                            <div class="upload-content">
                                <div class="upload-btn">
                                    <input type="file" name="product_image" accept="image/*"
                                        onchange="previewProfilePicture(event)">
                                    <span>
                                        <i class="ti ti-file-broken"></i> Upload Product Image
                                    </span>
                                </div>
                                <p>JPG, GIF or PNG. Max size of 2MB</p>
                                <div id="product_image_error" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="product_name" value="{{ old('product_name') }}"
                                class="form-control" placeholder="Product Name">
                            <div id="product_name_error" class="error-message text-danger"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Category <span class="text-danger">*</span></label>
                            <select class="select" name="category_id" value="{{ old('category_id') }}">
                                <option value="">Select category</option>
                                @if ($category)
                                    @foreach ($category as $c)
                                        <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No record</option>
                                @endif

                            </select>
                            <div id="category_id_error" class="error-message text-danger"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Grade <span class="text-danger">*</span></label>
                            <select class="select" name="grade_id" value="{{ old('grade_id') }}">

                                <option value="">Select grade</option>
                                @if ($grads)
                                    @foreach ($grads as $g)
                                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No record</option>
                                @endif
                            </select>
                            <div id="grade_id_error" class="error-message text-danger"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="col-form-label">Status</label>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <input type="radio" class="status-radio" id="active1" name="status"
                                        value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                    <label for="active1">Active</label>
                                </div>
                                <div>
                                    <input type="radio" class="status-radio" id="inactive1" name="status"
                                        value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                    <label for="inactive1">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-2">
                            <div class="radio-wrap">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="col-form-label">Select Variation</label>
                                    </div>
                                </div>
                                <div class="field-group field-group-new">

                                    {{-- <div class="field-group"> --}}
                                    <div>
                                        <label class="col-form-label">Dealer Price <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="dealer_price[]" placeholder="Price"
                                            class="form-control">
                                    </div>
                                    <div>
                                        <label class="col-form-label">Distributor Price <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="distributor_price[]" placeholder="Price"
                                            class="form-control">
                                    </div>
                                    <div>
                                        <label class="col-form-label">Variation Name <span
                                                class="text-danger">*</span></label>
                                        <select class="select addfileddrop load_variation_value" name="variation_id[]">
                                            <option value="">Select Variation</option>
                                            @if ($variations)
                                                @foreach ($variations as $v)
                                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No record</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div>
                                        <label class="col-form-label">Variation Value <span
                                                class="text-danger">*</span></label>
                                        <select class="select addfileddrop" name="variation_option_id[]">
                                            <option value="">Select option</option>
                                        </select>
                                    </div>
                                    <button type="button" class="add-btn btn btn-primary mb-1"
                                        onclick="addField('yes')">Add
                                        New</button>
                                    <div>
                                    </div>
                                    {{-- </div> --}}

                                </div>
                            </div>
                        </div>
                        <div id="fields-container"></div>
                        <div id="not_count_match" class="text-danger"></div>
                    </div>

                </div>

                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#create_success">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    /***** Add validation functionality  *****/
    $(document).ready(function() {
        $("form").on("submit", function(e) {
            var valid = true;
            var variationValid = false;
            var errorMessage = ""; // Single error message container

            /* Reset previous error messages */
            $("#product_image_error").html("");
            $("#product_name_error").html("");
            $("#category_id_error").html("");
            $("#grade_id_error").html("");
            $("#variation_error").html("");

            /* Validate Product Image */
            let product_image_field = $("input[name='product_image']");
            let file = product_image_field[0].files[0]; // Get the selected file

            // if (!product_image_field.val().trim()) {
            // if (!file) {
            //     $("#product_image_error").html("The product image is required.");
            //     valid = false;
            // } else {
            //     // Check file type (JPG, GIF, PNG)
            //     let validExtensions = ['jpg', 'jpeg', 'gif', 'png'];
            //     let fileExtension = file.name.split('.').pop().toLowerCase();

            //     if (!validExtensions.includes(fileExtension)) {
            //         $("#product_image_error").html(
            //             "Invalid file type. Only JPG, GIF, and PNG are allowed.");
            //         valid = false;
            //     }

            //     // Check file size (max 800KB)
            //     if (file.size > 2097152) { // 2MB = 2,097,152 bytes || 800KB = 800000 bytes  ||  8KB = 8,192 bytes.
            //         $("#product_image_error").html("File size must be less than 2MB.");
            //         valid = false;
            //     }
            // }

            // Only validate if file is selected
            if (file) {
                let validExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                let fileExtension = file.name.split('.').pop().toLowerCase();

                // Validate extension
                if (!validExtensions.includes(fileExtension)) {
                    $("#product_image_error").html(
                        "Invalid file type. Only JPG, GIF, and PNG are allowed.");
                    valid = false;
                }

                // Validate file size (max 2MB)
                if (file.size > 2097152) { //2097152
                    $("#product_image_error").html("File size must be less than 2MB.");
                    valid = false;
                }
            }



            /* Validate Product Name */
            let product_name_field = $("input[name='product_name']");
            if (!product_name_field.val().trim()) {
                $("#product_name_error").html("The product name field is required.");
                valid = false;
            }

            /* Validate Category Selection */
            let category_id_field = $("select[name='category_id']");
            if (!category_id_field.val()) {
                $("#category_id_error").html("Please select a category.");
                valid = false;
            }

            /* Validate Grade Selection */
            let grade_id_field = $("select[name='grade_id']");
            if (!grade_id_field.val()) {
                $("#grade_id_error").html("Please select a grade.");
                valid = false;
            }

            /*** Get selected variation type ****/
            let variationType = ''; //$("input[name='variation']:checked").val();
            // alert(variationType == 'yes');

            /* onchange variation */
            // $("input[name='variation']").on('change', function() {
            //     $("#not_count_match").html("");
            // });

            if (variationType == '') {
                /* Check Dealer Prices */
                $("input[name='dealer_price[]']").each(function() {
                    if (!$(this).val().trim()) {
                        variationValid = true;
                    }
                });
                // Check Distributor Prices
                $("input[name='distributor_price[]']").each(function() {
                    if (!$(this).val().trim()) {
                        variationValid = true;
                    }
                });
                // Check variation name
                $("select[name='variation_id[]']").each(function() {
                    if (!$(this).val().trim()) {
                        variationValid = true;
                    }
                });
                // Check Size Selection
                $("select[name='variation_option_id[]']").each(function() {
                    if (!$(this).val()) {
                        variationValid = true;
                    }
                });

                if (variationValid) {
                    $("#not_count_match").html(
                        // "All dealer prices, distributor prices, and size fields are required.");
                        "All fields are required.");
                    valid = false;
                } else {
                    $("#not_count_match").html(""); // Clear error message if all fields are filled
                }
            }
            if (variationType == "no") {
                let variationValid = false;

                // Check Price field
                $("input[name='price[]']").each(function() {
                    if (!$(this).val().trim()) {
                        variationValid = true;
                    }
                });

                if (variationValid) {
                    errorMessage = "Price field is required.";
                }
            }

            // Show error if any field is empty
            if (errorMessage) {
                $("#not_count_match").html(errorMessage);
                valid = false;
            }

            if (!valid) {
                e.preventDefault(); /* Prevent form submission if validation fails */
            }

        });
    });



    /***** Add new Variation For status(Yes/no)  *****/
    $(document).ready(function() {

        /* Variation name wise get Variation Value */
        $(document).on('change', 'select[name="variation_id[]"]', function() {
            let selectedVariationId = $(this).val();
            let sizeDropdown = $(this).closest('.field-group').find(
                'select[name="variation_option_id[]"]');

            if (selectedVariationId) {
                $.ajax({
                    url: "{{ route('variation.get') }}", // Laravel route for fetching sizes
                    type: "POST",
                    data: {
                        variation_id: selectedVariationId,
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            let sizeOptions = '<option value="">Select option</option>';
                            $.each(response.variations, function(index, size) {
                                sizeOptions +=
                                    `<option value="${size.id}">${size.value}</option>`;
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


        /* Add new variations (Yes)fields */
        $(document).on('change', 'input[name="variation"]', function() {
            let selectedValue = $(this).val();
            let container = $("#fields-container");
            container.html(""); // Clear previous fields

            if (selectedValue === "yes") {
                let variations = @json($variations); // Laravel data passed as JSON
                let variationOptions = '';

                // Loop through variations to populate the dropdown
                variations.forEach(function(variation) {
                    variationOptions +=
                        `<option value="${variation.id}">${variation.name}</option>`;
                });

                // container.append(`
                //     <div class="field-group">
                //         <div>
                //             <label class="col-form-label">Dealers</label>
                //             <input type="number" name="dealer_price[]" placeholder="Price" class="form-control">
                //         </div>
                //         <div>
                //             <label class="col-form-label">Distributor</label>
                //             <input type="number" name="distributor_price[]" placeholder="Price" class="form-control">
                //         </div>
                //         <div>
                //             <label class="col-form-label">Variation name</label>
                //             <select class="select addfileddrop load_variation_value" name="variation_id[]">
                //                 <option value="">Select Variation</option>
                //                 ${variationOptions}
                //             </select>
                //         </div>
                //         <div>
                //             <label class="col-form-label">Variation Value</label>
                //             <select class="select addfileddrop " name="variation_value[]">
                //                 <option value="">Select Variation</option>
                //             </select>
                //         </div>
                //         <button type="button" class="add-btn btn btn-primary" onclick="addField('yes')">Add New</button>
                //         <div>
                //         </div>
                //     </div>
                // `);
            }
            // else if (selectedValue === "no") {
            //     container.append(`
            //         <div class="field-group row">
            //             <input type="number" name="price[]" placeholder="Price" class="form-control">
            //             </div>
            //             `);
            // }
        });
    });
    // <button type="button" class="add-btn btn btn-primary" onclick="addField('no')">Add New</button>


    function addField(type) {
        let container = $("#fields-container");
        if (type === "yes") {
            let variations = @json($variations); // Laravel data passed as JSON
            let variationOptions = '';

            // Loop through variations to populate the dropdown
            variations.forEach(function(variation) {
                variationOptions +=
                    `<option value="${variation.id}">${variation.name}</option>`;
            });
            container.append(`
                <div class="field-group">
                    <input type="number" name="dealer_price[]" placeholder="Price" class="form-control">
                    <input type="number" name="distributor_price[]" placeholder="Price" class="form-control">
                    <select class="select addfileddrop" name="variation_id[]">
                            <option value="">Select Variation</option>
                            ${variationOptions}
                        </select>
                    <select class="select addfileddrop load_variation_value" name="variation_option_id[]">
                        <option>Select option</option>

                    </select>
                    <button type="button" class="remove-btn btn btn-danger mb-1" onclick="removeField(this)">Remove</button>
                </div>
            `);
        } else if (type === "no") {
            container.append(`
                <div class="field-group row">
                    <input type="number" name="price[]" placeholder="Price" class="form-control">
                    <button type="button" class="remove-btn btn btn-danger" onclick="removeField(this)">Remove</button>
                </div>
            `);
        }
    }

    /***** Remove new functionality *****/
    function removeField(button) {
        $(button).closest(".field-group").remove();
    }

    function previewProfilePicture(event) {
        const file = event.target.files[0]; // Get the selected file
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target
                    .result; // Set image preview source
            }
            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    }
</script>
@endsection
