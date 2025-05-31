@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="card">
    <div class="card-body">
        <div class="prodctmain">
            <form action="{{ route('variation.update', $variation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label @error('name') is-invalid @enderror">
                                Variation Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $variation->name) }}"
                                class="form-control">
                            <div id="name_error" class="error-message text-danger"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="col-form-label">Status</label>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <input type="radio" class="status-radio" id="active1" name="status"
                                        value="1" {{ old('status', $variation->status) == '1' ? 'checked' : '' }}>
                                    <label for="active1">Active</label>
                                </div>
                                <div>
                                    <input type="radio" class="status-radio" id="inactive1" name="status"
                                        value="0" {{ old('status', $variation->status) == '0' ? 'checked' : '' }}>
                                    <label for="inactive1">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="priceproductvariation-list">
                                @foreach ($variation->variant_options as $index => $option)
                                    <div class="field-group gap-2 mb-2">
                                         <input type="hidden" name="variation_option_id[]" value="{{ $option->id }}">
                                        <input type="number" name="weight[]"
                                            value="{{ old('weight.' . $index, $option->value) }}"
                                            placeholder="weight" class="form-control">
                                         <select name="unit[]" class="form-control">
                                            <option value="Kg" {{ old('unit.' . $index, $option->unit) == 'Kg' ? 'selected' : ''}}>Kg</option>
                                            <option value="Ltr" {{ old('unit.' . $index, $option->unit) == 'Ltr' ? 'selected' : ''}}>Ltr</option>
                                            <option value="Ml" {{ old('unit.' . $index, $option->unit) == 'Ml' ? 'selected' : ''}}>Ml</option>
                                        </select>
                                        {{-- <button type="button" class="remove-btn btn btn-danger"
                                            onclick="removeField(this)">Remove</button> --}}
                                        @if ( !in_array($option->id,
                                                App\Models\ProductVariation::pluck('variation_option_id')->all()))
                                            <button type="button" class="remove-btn btn btn-danger mb-1"
                                                onclick="removeField(this)">Remove</button>
                                        @endif

                                    </div>
                                @endforeach
                                {{-- If no existing variations, show an empty field --}}
                                @if ($variation->variant_options->isEmpty())
                                    <div class="field-group gap-2 mb-2">
                                        <input type="number" name="weight[]" placeholder="weight"
                                            class="form-control">
                                        <select name="unit[]" class="form-control ">
                                            <option value="Kg">Kg</option>
                                            <option value="Ltr">Ltr</option>
                                            <option value="Ml">Ml</option>
                                        </select>
                                        <button type="button" class="remove-btn btn btn-danger"
                                            onclick="removeField(this)">Remove</button>
                                    </div>
                                @endif
                            </div>
                            <div id="not_count_match" class="text-danger"></div>
                            <button type="button" class="add-btn btn btn-primary" onclick="addField()">Add
                                New</button>
                        </div>

                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end">
                    {{-- <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button> --}}
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    /***** Add new functionality *****/
    function addField() {
        let container = $(".priceproductvariation-list");

        // Convert the last "Add New" button to a "Remove" button
        let newRow = `
        <div class="field-group gap-2 mb-2">
            <input type="number" name="weight[]" placeholder="weight" class="form-control">
             <select name="unit[]" class="form-control">
                     <option value="Kg">Kg</option>
                    <option value="Ltr">Ltr</option>
                    <option value="Ml">Ml</option>
                </select>
            <button type="button" class="remove-btn btn btn-danger"
                                            onclick="removeField(this)">Remove</button>
        </div>
    `;

        container.append(newRow);
    }

    function removeField(button) {
        let container = $(".priceproductvariation-list");

        // Ensure at least one field remains
        // if (container.find(".field-group").length > 1) {
        $(button).closest(".field-group").remove();
        // }
    }


    /***** Remove new functionality *****/
    // function removeField(button) {
    //     $(button).closest(".field-group").remove();
    // }

    /***** Add new functionality validation *****/
    $(document).ready(function() {
        $("form").on("submit", function(e) {
            var valid = true;
            var weightValid = false; // Track if at least one weight field is empty

            // Reset previous error messages
            $(".error-message").html("");

            // Validate 'name' field
            let nameField = $("input[name='name']");
            if (!nameField.val().trim()) {
                $("#name_error").html("The variation name field is required.");
                valid = false;
            }

            // Validate 'weight[]' fields (if any are empty, show one general message)
            $("input[name='weight[]']").each(function() {
                if (!$(this).val().trim()) {
                    weightValid = true;
                }
            });

            if (weightValid) {
                $("#not_count_match").html("The weight field are required.");
                valid = false;
            } else {
                $("#not_count_match").html(""); // Clear error message if all fields are filled
            }

            if (!valid) {
                e.preventDefault(); // Stop form submission if validation fails
            }
        });
    });
</script>
@endsection
