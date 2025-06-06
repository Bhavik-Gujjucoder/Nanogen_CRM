@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-body">
        <div class="prodctmain">
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-pic-upload">
                            <div class="profile-pic">
                                <img id="profilePreview" {{-- src="{{ asset('storage/product_images/' . ($product->product_image ?? 'images/default-user.png')) }}" --}}
                                    src="{{ !empty($product->product_image) ? asset('storage/product_images/' . $product->product_image) : asset('images/default-user.png') }}"
                                    alt="Product Image" class="img-thumbnail mb-2">
                            </div>
                            <div class="upload-content">
                                <div class="upload-btn">
                                    <input type="file" name="product_image" accept=".jpg,.jpeg,.gif,.png"
                                        onchange="previewProfilePicture(event)">
                                    <span>
                                        <i class="ti ti-file-broken"></i> Upload Product Image
                                    </span>
                                </div>
                                <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                                <div id="product_image_error" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="product_name"
                                value="{{ old('product_name', $product->product_name) }}" class="form-control"
                                placeholder="Product Name">
                            <div id="product_name_error" class="error-message text-danger"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Category <span class="text-danger">*</span></label>
                            <select class="select" name="category_id">
                                <option value="">Select category</option>
                                @if ($category)
                                    @foreach ($category as $c)
                                        <option value="{{ $c->id }}"
                                            {{ $product->category_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->category_name }}
                                        </option>
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
                            <select class="select" name="grade_id">
                                <option value="">Select grade</option>
                                @if ($grads)
                                    @foreach ($grads as $g)
                                        <option value="{{ $g->id }}"
                                            {{ $product->grade_id == $g->id ? 'selected' : '' }}>{{ $g->name }}
                                        </option>
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
                            <label class="col-form-label">Status <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <input type="radio" class="status-radio" id="active1" name="status"
                                        value="1" {{ $product->status == '1' ? 'checked' : '' }}>
                                    <label for="active1">Active</label>
                                </div>
                                <div>
                                    <input type="radio" class="status-radio" id="inactive1" name="status"
                                        value="0" {{ $product->status == '0' ? 'checked' : '' }}>
                                    <label for="inactive1">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-1">
                            <label class="col-form-label">Select Variation</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-0 gc-price-menu">
                        <div class="field-group field-group-new">
                            <label for="col-form-label" class="col-form-label">Dealer Price <span
                                    class="text-danger">*</span></label>
                            <label for="col-form-label" class="col-form-label">Distributor Price <span
                                    class="text-danger">*</span></label>
                            <label for="col-form-label" class="col-form-label">Variation Name <span
                                    class="text-danger">*</span></label>
                            <label for="col-form-label" class="col-form-label">Variation Value <span
                                    class="text-danger">*</span></label>
                            <button type="button" class="add-btn btn btn-primary" onclick="addField('yes')">Add
                                New</button>
                        </div>

                        @if ($product->product_variations)
                            <div id="fields-container">
                                @foreach ($product->product_variations as $variation)
                                    <div class="field-group  product-variaton-column">
                                        <input type="number" name="dealer_price[]"
                                            value="{{ $variation->dealer_price }}" class="form-control"
                                            placeholder="Dealer Price">

                                        <input type="number" name="distributor_price[]"
                                            value="{{ $variation->distributor_price }}" class="form-control"
                                            placeholder="Distributor Price">

                                        <select class="select" name="variation_id[]">
                                            <option value="">Select Variation</option>
                                            @foreach ($variations as $v)
                                                <option value="{{ $v->id }}"
                                                    {{ $variation->variation_id == $v->id ? 'selected' : '' }}>
                                                    {{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select" name="variation_option_id[]">
                                            @foreach (getVariationOptions($variation->variation_id) as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $variation->variation_option_value ? ($variation->variation_option_value->id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->value }} {{ $item->unit }}</option>
                                            @endforeach
                                        </select>

                                        @if ( !in_array($variation->variation_option_value->id,
                                                App\Models\OrderManagementProduct::where('product_id',$product->id)->pluck('packing_size_id')->all()))
                                            <button type="button" class="remove-btn btn btn-danger mb-1"
                                                onclick="removeField(this)">Remove</button> 
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="not_count_match" class="text-danger"></div>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
    /***** Variation name wise get Variation Value  *****/
    $(document).ready(function() {
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
                            let sizeOptions = '<option value="">Select Variation Value</option>';
                            $.each(response.variations, function(index, size) {
                                sizeOptions +=
                                    `<option value="${size.id}">${size.value} ${size.unit}</option>`;
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
    });

    /* Add New functionality */
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
            container.prepend(`
            <div class="field-group product-variaton-column">
                <input type="number" name="dealer_price[]" placeholder="Dealer Price" class="form-control">
                <input type="number" name="distributor_price[]" placeholder="Distributor Price" class="form-control">
                <select class="select addfileddrop" name="variation_id[]">
                        <option value="">Select Variation</option>
                        ${variationOptions}
                    </select>
                <select class="select addfileddrop load_variation_value" name="variation_option_id[]">
                    <option>Select Variation Value</option>

                </select>
                <button type="button" class="remove-btn btn btn-danger mb-1" onclick="removeField(this)">Remove</button>
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

    /***** Add new functionality validation *****/
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
            let variationType = $("input[name='variation']:checked").val();

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

            // Check if at least one variation block exists
            if ($(".product-variaton-column").length === 0) {
                errorMessage = "At least one product variation is required.";
                valid = false;
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
</script>
@endsection
