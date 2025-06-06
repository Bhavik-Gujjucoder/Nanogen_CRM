@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="card">
    <div class="card-body">
        <form action="{{ route('complain.update', $complain->id) }}" id="complainForm" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="edit-distributorsform">
                <!-- Basic Info -->
                <div class="applicationdtl">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="profile-pic-upload">
                                <div class="upload-content">
                                    <div class="upload-btn  @error('complain_image') is-invalid @enderror">
                                        <input type="file" name="complain_image" {{-- accept=".jpg,.jpeg,.gif,.png" --}}
                                            onchange="previewProfilePicture(event)">
                                        <span>
                                            <i class="ti ti-file-broken"></i>Upload File
                                            <div id="previewArea"></div>
                                        </span>
                                    </div>
                                    @error('complain_image')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                @if ($complain->complain_image)
                                    @php
                                        $fileExtension = pathinfo($complain->complain_image, PATHINFO_EXTENSION);
                                        $fileUrl = asset('storage/complain_images/' . $complain->complain_image);
                                    @endphp

                                    @if (strtolower($fileExtension) === 'pdf')
                                        <!-- PDF Preview -->
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="btn btn-sm btn-primary">View PDF File</a>
                                        <br>
                                        {{-- <iframe src="{{ $fileUrl }}"
                                            style="width: 150px; height: 100px;"
                                            class="mb-2"></iframe> --}}
                                    @elseif (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <!-- Image Preview -->
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <img src="{{ $fileUrl }}" alt="Preview" class="img-thumbnail mb-2"
                                                style="max-width: 200px;">
                                        </a>
                                    @else
                                        <!-- Other File Preview -->
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="btn btn-sm "><strong>{{ $complain->complain_image }}</strong></a>
                                        {{-- <p>📁 <strong>{{ $complain->complain_image }}</strong></p> --}}
                                    @endif
                                @endif
                                {{-- <div id="previewArea"></div> --}}
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="mb-3">
                                <label class="col-form-label"> Select Dealer/ Distributor <span
                                        class="text-danger">*</span></label>
                                <select class="form-control form-select search-dropdown" name="dd_id">
                                    <option value="">Select</option>
                                    @php
                                        $selectedDdId = old('dd_id', $complain->dd_id ?? '');
                                    @endphp
                                    @if ($dds->count() > 0)
                                        @foreach ($dds as $dd)
                                            <option value="{{ $dd->id }}"
                                                {{ $selectedDdId == $dd->id ? 'selected' : '' }}
                                                data-user_type="{{ $dd->user_type }}">
                                                {{ $dd->applicant_name }}
                                                {{ $dd->user_type == 1 ? '(Distributor)' : ($dd->user_type == 2 ? '(Dealer)' : '') }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No record</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="icon-form">
                                    <span class="form-icon"><i class="ti ti-calendar-check"></i></span>
                                    <input type="text" name="date" class="form-control datetimepicker"
                                        id="datePicker"
                                        value="{{ old('date', \Carbon\Carbon::parse($complain->date)->format('d-m-y')) }}"
                                        placeholder="Enter Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mb-3">
                                <label class="col-form-label"> Product selection <span
                                        class="text-danger">*</span></label>
                                <select class="form-control form-select search-dropdown" name="product_id">
                                    <option selected disabled>Select</option>
                                    @php
                                        $selectedProductId = old('product_id', $complain->product_id ?? '');
                                    @endphp

                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $selectedProductId == $product->id ? 'selected' : '' }}>
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="mb-3">
                                <label class="col-form-label"> Status <span class="text-danger">*</span></label>
                                @php
                                    $selectedStatus = old('status', $complain->status ?? '');
                                @endphp

                                <select class="select" name="status" id="status">
                                    <option value="0" {{ $selectedStatus == 0 ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="1" {{ $selectedStatus == 1 ? 'selected' : '' }}>In progress
                                    </option>
                                    <option value="2" {{ $selectedStatus == 2 ? 'selected' : '' }}>Under review
                                    </option>
                                    <option value="3" {{ $selectedStatus == 3 ? 'selected' : '' }}>Completed
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Description <span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control" name="description">{{ $complain->description ?? old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Remarks<span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control remark" name="remark">{{ $complain->remark ?? old('remark') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (!$complain_status_history->isEmpty())
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Complain Status History</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($complain_status_history as $history)
                                    <tr>
                                        <td data-label="Date">{{ \Carbon\Carbon::parse($history->created_at)->format('d-m-Y') }}</td>
                                        <td data-label="Status">
                                            @if ($history->status == 1)
                                                In progress
                                            @elseif($history->status == 2)
                                                Under review
                                            @elseif($history->status == 3)
                                                Completed
                                            @elseif($history->status == 0)
                                                Pending
                                            @endif
                                        </td>
                                        <td data-label="Remarks">{{ $history->remark }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="d-flex align-items-center justify-content-end">
                <!-- <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a> -->
                <button type="submit" class="btn btn-primary mb-4">Update</button>
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
        disableMobile: true,
        maxDate: "today",
        defaultDate: "{{ old('date', isset($complain) ? \Carbon\Carbon::parse($complain->date)->format('d-m-Y') : now()->format('d-m-Y')) }}",
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

    $.validator.addMethod("noSpace", function(value, element) {
        return $.trim(value).length > 0;
    }, "This field cannot be empty or just spaces.");
    /*** validation  ***/
    $(document).ready(function() {
        $("#complainForm").validate({
            ignore: [],
            rules: {
                dd_id: {
                    required: true
                },
                date: {
                    required: true,
                    // date: true
                },
                product_id: {
                    required: true,
                },
                status: {
                    required: true
                },
                description: {
                    required: true,
                    noSpace: true
                },
                remark: {
                    required: true,
                    noSpace: true
                },
            },
            messages: {
                dd_id: "Please select dealer/distributor",
                date: "Please enter a valid date",
                product_id: "Please select a product",
                status: "Please select a status",
                // description: "Please enter a description",
                // remark: "Please enter a remark",
                description: {
                    required: "Please enter a description",
                    noSpace: "Description cannot be just spaces"
                },
                remark: {
                    required: "Please enter a remark",
                    noSpace: "Remark cannot be just spaces"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    error.addClass('text-danger');
                    error.insertAfter(element.next(
                        '.select2')); // This targets the Select2 container
                } else {
                    error.addClass('text-danger');
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            success: function() {}
        });
    });

    /*** Image ***/
    // function previewProfilePicture(event) {
    //     const file = event.target.files[0]; // Get the selected file
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             document.getElementById('profilePreview').src = e.target
    //                 .result; // Set image preview source
    //         }
    //         reader.readAsDataURL(file); // Read the file as a Data URL
    //     }
    // }

    function previewProfilePicture(event) {
        const files = event.target.files;
        const previewArea = document.getElementById('previewArea');
        previewArea.innerHTML = ''; // Clear previous previews

        Array.from(files).forEach(file => {
            const fileType = file.type;

            const reader = new FileReader();
            reader.onload = function(e) {
                let element;

                if (fileType.startsWith('image/')) {
                    // Preview Image
                    element = document.createElement('img');
                    element.src = e.target.result;
                    // element.style.maxWidth = '200px';
                    // element.style.margin = '10px';
                    element.style.height = '150px';
                    element.style.width = '150px';
                } else if (fileType === 'application/pdf') {
                    // Preview PDF
                    element = document.createElement('iframe');
                    element.src = e.target.result;
                    // element.width = '150px';
                    // element.height = '100px';
                    element.style.maxWidth = '200px';
                    element.style.margin = '10px';
                } else if (
                    file.name.endsWith('.xlsx') ||
                    file.name.endsWith('.xls')
                    // ||
                    // fileType ===
                    // 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ) {
                    // Excel File Preview - Show file name with icon
                    element = document.createElement('div');
                    element.innerHTML = `<p>📊 <strong>${file.name}</strong> (Excel file)</p>`;
                } else {
                    // Other file types
                    element = document.createElement('div');
                    element.innerHTML =
                        `<p>📁 <strong>${file.name}</strong></p>`;
                }

                previewArea.appendChild(element);
            };

            // For non-previewable files like Excel, just skip reading
            if (fileType.startsWith('image/') || fileType === 'application/pdf') {
                reader.readAsDataURL(file);
            } else {
                reader.onload(); // Direct call for name-based preview
            }
        });
    }


    $('#status').change(function() {
        $('.remark').val('');
    });
</script>
@endsection
