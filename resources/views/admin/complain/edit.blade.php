@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="card">
    <div class="card-body">
        <form action="{{ route('complain.update', $complain->id) }}" id="complainForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="edit-distributorsform">
                <!-- Basic Info -->
                <div class="applicationdtl">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="profile-pic-upload">
                            <div class="profile-pic">
                                <img id="profilePreview" src="{{ $complain->complain_image ? asset('storage/complain_images/' . $complain->complain_image) : asset('images/default-user.png') }}"
                                    alt="Profile Picture" class="img-thumbnail mb-2">
                            </div>
                            <div class="upload-content">
                            <div class="upload-btn  @error('complain_image') is-invalid @enderror">
                                <input type="file" name="complain_image" accept="image/*" onchange="previewProfilePicture(event)">
                                <span>
                                <i class="ti ti-file-broken"></i>Upload File
                                </span>
                            </div>
                            <p>JPG, JPEG, GIF or PNG. Max size of 2MB</p>
                            @error('complain_image')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="mb-3">
                            <label class="col-form-label"> Select Dealer/ Distributor <span class="text-danger">*</span></label>
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
                            <input type="text" name="date" class="form-control datetimepicker" id="datePicker" 
                            value="{{ old('date', $complain->date->format('d-m-y')) }}"placeholder="Enter Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="mb-3">
                            <label class="col-form-label"> Product selection <span class="text-danger">*</span></label>
                            <select class="form-control form-select search-dropdown" name="product_id">
                                <option selected disabled>Select</option>
                                @php
                                    $selectedProductId = old('product_id', $complain->product_id ?? '');
                                @endphp

                                @foreach($products as $product)
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
                            <label class="col-form-label"> Status  <span class="text-danger">*</span></label>
                            @php
                                $selectedStatus = old('status', $complain->status ?? '');
                            @endphp

                            <select class="select" name="status" id="status">
                                <option value="0" {{ $selectedStatus == 0 ? 'selected' : ''}}>Pending</option>
                                <option value="1" {{ $selectedStatus == 1 ? 'selected' : '' }}>In progress</option>
                                <option value="2" {{ $selectedStatus == 2 ? 'selected' : '' }}>Under review</option>
                                <option value="3" {{ $selectedStatus == 3 ? 'selected' : '' }}>Completed</option>
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
            </div>
            @if(!$complain_status_history->isEmpty())
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
                                @foreach($complain_status_history as $history)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            @if($history->status == 1)
                                                In progress
                                            @elseif($history->status == 2)
                                                Under review
                                            @elseif($history->status == 3)
                                                Completed
                                            @endif
                                        </td>
                                        <td>{{ $history->remark }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="d-flex align-items-center justify-content-end">
                <!-- <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a> -->
                <button type="submit" class="btn btn-primary">Update</button>
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
                    required: true
                },
                remark: {
                    required: true
                },
            },
            messages: {
                dd_id: "Please select dealer/distributor",
                date: "Please enter a valid date",
                product_id: "Please select a product",
                status: "Please select a status",
                description: "Please enter a description",
                remark: "Please enter a remark",
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
            success: function() {
            }
        });
    });

    /*** Image ***/
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

    $('#status').change(function() {
        $('.remark').val('');
    });
</script>
@endsection
