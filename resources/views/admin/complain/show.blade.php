<h3>{{ $page_title }}</h3>
<div class="card">
    <div class="card-body">
        <div class="edit-distributorsform">
            <div class="applicationdtl">
                <div class="row">

                    <!-- Existing Files Section -->
                    <div class="col-md-12">
                        <div class="profile-pic-upload d-block mb-3">

                            @if ($complain->complain_image)
                            @php
                            $files = json_decode($complain->complain_image, true) ?? [];
                            @endphp

                            @if ($files)
                            <div class="mt-3">
                                <label class="fw-bold">All Files</label>

                                <div class="d-flex flex-wrap gap-2 mt-2 img-box" id="existingFiles">
                                    @foreach ($files as $file)
                                    @php
                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    $fileUrl = asset('storage/complain_images/' . $file);
                                    @endphp

                                    <div class="position-relative border" style="width:120px;height:120px">

                                        {{-- Image Preview --}}
                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <img src="{{ $fileUrl }}"
                                                style="width:100%;height:100%;object-fit:cover;border:1px solid #ddd">
                                        </a>

                                        {{-- PDF Preview --}}
                                        @elseif ($ext === 'pdf')
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="d-flex flex-column align-items-center justify-content-center border h-100 text-decoration-none">
                                            📄 <small>PDF</small>
                                        </a>

                                        {{-- Other Files --}}
                                        @else
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="d-flex flex-column align-items-center justify-content-center h-100 text-decoration-none text-center p-1">
                                            📁
                                            <small style="word-break:break-all;">
                                                {{ $file }}
                                            </small>
                                        </a>
                                        @endif

                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @endif

                        </div>
                    </div>
                </div>
                <!-- Firm Name -->
                <div class="order-form order-form-clss row">
                    <div class="col-md-4 mb-3 mt-3">
                        <div class="mb-3">
                            <label class="col-form-label">Firm Name :</label>
                            <strong>
                                {{ $complain->distributorsDealers->firm_shop_name }}
                                {{ $complain->distributorsDealers->user_type == 1 ? '(Distributor)' : ($complain->distributorsDealers->user_type == 2 ? '(Dealer)' : '') }}
                            </strong>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="col-md-4 mb-3 mt-3">
                        <div class="mb-3">
                            <label class="col-form-label">Date :</label>
                            <strong>{{ \Carbon\Carbon::parse($complain->date)->format('d M Y') }}</strong>
                        </div>
                    </div>

                    <!-- Product -->
                    <div class="col-md-4 mb-3 mt-3">
                        <div class="mb-3">
                            <label class="col-form-label">Product :</label>
                            <strong>{{ $complain->product->product_name }}</strong>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3 ">
                        <div class="mb-3">
                            <label class="col-form-label">Status :</label>

                            @php
                            $selectedStatus = old('status', $complain->status ?? '');
                            @endphp

                            <strong>
                                @if ($selectedStatus == 0)
                                Pending
                                @elseif ($selectedStatus == 1)
                                In progress
                                @elseif ($selectedStatus == 2)
                                Under review
                                @elseif ($selectedStatus == 3)
                                Completed
                                @endif
                            </strong>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Description :</label>
                            <strong>{{ $complain->description ?? '-' }}</strong>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label">Remarks :</label>
                            <strong>{{ $complain->remark ?? '-' }}</strong>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @if (!$complain_status_history->isEmpty())
        <div class="row mb-3 mt-3">
            <div class="col-md-12">
                <h5 class="complain_status_history">Complain Status History</h5>
                <table class="table table-bordered mt-3">
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
                            <td data-label="Date">
                                {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y') }}
                            </td>
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
    </div>
</div>