@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="card">
    <div class="card-body">
        <div class="prodctmain">
            <form action="{{ route('variation.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label @error('name') is-invalid @enderror">Variation Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Variation Name" class="form-control">
                            <div id="name_error" class="error-message text-danger"></div>
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
                        <div class="mb-3">
                            <div class="priceproductvariation-list gc-variation-list">
                                <div class="field-group gap-2 mb-2">
                                    <input type="number" name="weight[]" placeholder="weight" class="form-control">
                                    <select name="unit[]" class="form-control">
                                        <option value="Kg">Kg</option>
                                        <option value="Ltr">Ltr</option>
                                        <option value="Ml">Ml</option>
                                    </select>

                                    <button type="button" class="add-btn  btn btn-primary"
                                        onclick="addField('yes')">Add New</button>
                                </div>
                            </div>
                            <div id="not_count_match" class="text-danger"></div>
                        </div>
                        <div id="fields-container"></div>


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
    /***** Add new functionality *****/
    function addField() {
        let container = $(".priceproductvariation-list");
        // Convert the previous "Add New" button to a "Remove" button
        $(".add-btn").last().replaceWith(
            '<button type="button" class="remove-btn btn btn-danger" onclick="removeField(this)">Remove</button>');

        let newRow = `
            <div class="field-group gap-2 mb-2">
                <input type="number" name="weight[]" placeholder="weight" class="form-control">
                <select name="unit[]" class="form-control">
                     <option value="Kg">Kg</option>
                    <option value="Ltr">Ltr</option>
                    <option value="Ml">Ml</option>
                </select>
                <button type="button" class="add-btn btn btn-primary" onclick="addField()">Add New</button>
            </div>
        `;
        container.append(newRow);
    }

    /***** Remove new functionality *****/
    function removeField(button) {
        $(button).closest(".field-group").remove();
    }

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
                $("#not_count_match").html("All weight fields are required.");
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
