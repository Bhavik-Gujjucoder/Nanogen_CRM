<h3>{{ $page_title }}</h3>
<div class="card des-deler-form">
    <div class="card-body view-page">
        <div class="edit-distributorsform">
            <!-- Basic Info -->
            <div class="applicationdtl delerbox-border-b">
                <div class="section-title">Basic Information</div>
                <div class="distributer-cls">
                    @if (!empty($distributor_dealers->profile_image))
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    <img id="profilePreview"
                                        src="{{ $distributor_dealers && $distributor_dealers->profile_image
                                            ? asset('storage/distributor_dealer_profile_image/' . $distributor_dealers->profile_image)
                                            : asset('images/default-user.png') }}"
                                        alt="Profile Image" class="img-thumbnail mb-2">
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--
         <div class="radio-group-bg">
            <div class="radio-group-flex">
               @can('Distributors & Dealers')
               <div class="radio-group-tab">
                  <input type="radio" name="user_type" value="1"
                  {{ old('user_type', $distributor_dealers->user_type) == '1' ? 'checked' : '' }}
                    id="distributor-radio" class="create-deitr" />
                    <label for="distributor-radio">Distributor</label>
                </div>
                <div class="radio-group-tab">
                    <input type="radio" name="user_type" value="2"
                        {{ old('user_type', $distributor_dealers->user_type) == '2' ? 'checked' : '' }}
                        id="dealers-radio" class="create-deitr" />
                    <label for="dealers-radio">Dealers</label>
                </div>
                @endcan
            </div>
        </div>
        --}}
                    @if (!empty($distributor_dealers->sales_person_id))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Sales Person : </label>
                                <span
                                    class="info-value">{{ $distributor_dealers->sales_person->first_name . ' ' . $distributor_dealers->sales_person->last_name }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->code_no))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Code No :</label>
                                <span class="info-value">{{ $distributor_dealers->code_no }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->applicant_name))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Name of the Applicant :</label>
                                <span class="info-value">{{ $distributor_dealers->applicant_name }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->firm_shop_name))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label"> Name of the Firm/Shop :</label>
                                <span class="info-value"></span>{{ $distributor_dealers->firm_shop_name }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->firm_shop_address))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Address of the Firm/Shop :</label>
                                <span class="info-value">{{ $distributor_dealers->firm_shop_address }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->mobile_no))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Mobile No :</label>
                                <span class="info-value">{{ $distributor_dealers->mobile_no }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->pancard))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Pan Card No :</label>
                                <span class="info-value">{{ $distributor_dealers->pancard }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->gstin))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">GSTIN :</label>
                                <span class="info-value">{{ $distributor_dealers->gstin }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->aadhar_card))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Aadhar Card No :</label>
                                <span class="info-value">{{ $distributor_dealers->aadhar_card }}</span>
                            </div>
                        </div>
                    @endif

                    @if (!empty($distributor_dealers->registered_dealer))
                        <div class="dealerlist info-row">
                            <label class="col-form-label mright">Are you a registered dealer? :</label>
                            <span
                                class="info-value">{{ $distributor_dealers->registered_dealer == 'yes' ? 'Yes' : 'No' }}</span>
                        </div>
                    @endif

                    @if (!empty($distributor_dealers->state_id))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">State/Province :</label>
                                <span class="info-value">{{ $distributor_dealers->state->state_name }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->city_id))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">City :</label>
                                <span class="info-value"></span>{{ $distributor_dealers->city->city_name }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->postal_code))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Postal Code :</label>
                                <span class="info-value">{{ $distributor_dealers->postal_code }}</span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="applicationdtl delerbox-border-b">
                <div class="section-title">Details of Bank A/c.</div>
                <div class="distributer-cls">
                    @if (!empty($distributor_dealers->bank_name_address))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Name and Address of Bank :</label>
                                <span class="info-value">{{ $distributor_dealers->bank_name_address }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->account_no))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Account No :</label>
                                <span class="info-value">{{ $distributor_dealers->account_no }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->ifsc_code))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">IFSC Code :</label>
                                <span class="info-value">{{ $distributor_dealers->ifsc_code }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->security_cheque_detail))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Details of Security Cheque :</label>
                                <span class="info-value">{{ $distributor_dealers->security_cheque_detail }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->cheque_1))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.1 : </label>
                                <span class="info-value">{{ $distributor_dealers->cheque_1 }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->cheque_2))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.2 : </label>
                                <span class="info-value">{{ $distributor_dealers->cheque_2 }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->cheque_3))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Cheque No.3 :</label>
                                <span class="info-value">{{ $distributor_dealers->cheque_3 }}</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($distributor_dealers->name_authorised_signatory))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Name of Authorised Signatory :</label>
                                <span class="info-value">{{ $distributor_dealers->name_authorised_signatory }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="info-row">
                    <div class="listcheck mb-3">
                        <label class="col-form-label">Type of A/c. :</label>
                        <span class="info-value">
                            @if ($distributor_dealers->ac_type == 1)
                                Savings
                            @elseif($distributor_dealers->ac_type == 2)
                                Current
                            @else
                                Other (Please specify)
                            @endif
                        </span>
                    </div>
                </div>
                <div class="distributer-cls">
                    @if ($distributor_dealers->ac_type == 3)
                        <div class="info-row">
                            <label class=" col-form-label" for="other">Specify Other Account Type :</label>
                            <span class="info-value">{{ $distributor_dealers->other_ac_type }}</span>
                        </div>
                    @endif
                    @if ($distributor_dealers->fertilizer_license_check == 1 && !empty($distributor_dealers->fertilizer_license))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label"> Fertilizer License No :</label>
                                <span class="info-value">{{ $distributor_dealers->fertilizer_license }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($distributor_dealers->pesticide_license_check == 1 && !empty($distributor_dealers->pesticide_license))
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Pesticide License No :</label>
                                <span class="info-value">{{ $distributor_dealers->pesticide_license }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-2 row ">

                <div class="applicationdtl delerbox-border-b">
                    <div class="d-flex">
                        <div class="section-title">Name of firm/company under which dealership exist </div>
                    </div>
                    <div class="row">
                        @if (!empty($distributor_dealers->dealership_companies))
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-view addnewfield" id="dealership_companies">
                                        <thead>
                                            <tr>
                                                <th scope="col">S. No</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Products</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($distributor_dealers->dealership_companies as $c)
                                                <tr>
                                                    <td data-label="S.No.">{{ $loop->iteration ?? '-' }}</td>
                                                    <td data-label="Company Name">
                                                        <span>{{ $c->company_name ?? '-' }}</span>
                                                    </td>
                                                    <td data-label="Products">
                                                        <span>{{ $c->product->product_name ?? '-' }}</span>
                                                    </td>
                                                    <td data-label="Quantity">
                                                        <span>{{ $c->quantity ?? '-' }}</span>
                                                    </td>
                                                    <td data-label="Remarks">
                                                        <span>{{ $c->company_remarks ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="listcheck info-row">
                                <label class="col-form-label">Status of Firm :</label>
                                <span class="info-value">
                                    @if ($distributor_dealers->firm_status == 1)
                                        Proprietorship
                                    @elseif($distributor_dealers->firm_status == 2)
                                        Partnership
                                    @elseif($distributor_dealers->firm_status == 3)
                                        Limited Company
                                    @else
                                        Private Ltd. Co.
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="applicationdtl delerbox-border-b">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">Details of Proprietor/Partners/Directors:</div>
                            @if (!empty($distributor_dealers->proprietor_partner_director))
                                <div class="table-responsive">
                                    <table class="table table-view addnewfield" id="propertiesdataTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl.</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Date of Birth</th>
                                                <th scope="col">Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($distributor_dealers->proprietor_partner_director as $p)
                                                <tr>
                                                    <td data-label="S.No.">{{ $loop->iteration ?? '-' }}</td>
                                                    <td data-label="Name">
                                                        <span>{{ $p->name ?? '-' }}</span>
                                                    </td>
                                                    <td data-label="Date of Birth" class="dateofbirth">
                                                        <span>{{ $p->birthdate ? \Carbon\Carbon::parse($p->birthdate)->format('d M Y') : '-' }}</span>
                                                    </td>
                                                    <td data-label="Address">
                                                        <span>{{ $p->address ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="distributer-cls">
                            @if (!empty($distributor_dealers->associate_name_address))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Name and address of associate firm(s) :</label>
                                        <span
                                            class="info-value">{{ $distributor_dealers->associate_name_address }}</span>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->associate_name_address))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Indicate number of people employed in your firm
                                            (including active partners) :</label>
                                        <span class="info-value">{{ $distributor_dealers->indicate_number }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="appthreeyear-sec">
                        @if (
                            !empty($distributor_dealers->turnover1) ||
                                !empty($distributor_dealers->turnover2) ||
                                !empty($distributor_dealers->turnover3))
                            <label class=" mb-1 godwn-cap">Last three years turnover of your firm (in Rs.
                                Lacs/Cores)</label>
                            <div class="distributer-cls">
                                @if (!empty($distributor_dealers->turnover1))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">1st year turnover :</label>
                                            <span class="info-value">{{ $distributor_dealers->turnover1 }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($distributor_dealers->turnover2))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">2nd year turnover :</label>
                                            <span class="info-value">{{ $distributor_dealers->turnover2 }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($distributor_dealers->turnover3))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">3rd year turnover :</label>
                                            <span class="info-value">{{ $distributor_dealers->turnover3 }}</span>
                                        </div>
                                    </div>
                            </div>
                        @endif
                        @endif
                        @if (
                            $distributor_dealers->godown_facility == 'yes' ||
                                !empty($distributor_dealers->godown_size_capacity) ||
                                !empty($distributor_dealers->godown_address))
                            <div class="">
                                <div class="listcheck mb-3">
                                    <label class="col-form-label">Do you have Godown Facility? :</label>
                                    <span class="info-value">
                                        @if ($distributor_dealers->godown_facility == 'yes')
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </span>
                                </div>
                                <div id="godownSizeField">
                                    <div class="distributer-cls">
                                        @if (!empty($distributor_dealers->godown_size_capacity))
                                            <div class="info-row">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Indicate Size and Capacity of
                                                        Godown :</label>
                                                    <span
                                                        class="info-value">{{ $distributor_dealers->godown_size_capacity }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($distributor_dealers->godown_address))
                                            <div class="info-row">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Address of Godown : </label>
                                                    <span
                                                        class="info-value">{{ $distributor_dealers->godown_address }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="distributer-cls">
                        @if (!empty($distributor_dealers->expected_minimum_sales))
                            <div class="info-row">
                                <div class="mb-3">
                                    <label class="col-form-label">Expected Minimum Sales :</label>
                                    <span class="info-value">{{ $distributor_dealers->expected_minimum_sales }}</span>
                                </div>
                            </div>
                        @endif
                        @if (!empty($distributor_dealers->place))
                            <div class="info-row">
                                <div class="mb-3">
                                    <label class="col-form-label">Place :</label>
                                    <span class="info-value">{{ $distributor_dealers->place }}</span>
                                </div>
                            </div>
                        @endif
                        @if (!empty($distributor_dealers->date))
                            <div class="info-row">
                                <div class="mb-3">
                                    <label class="col-form-label">Date :</label>
                                    <span
                                        class="info-value">{{ $distributor_dealers->date ? \Carbon\Carbon::parse($distributor_dealers->date)->format('d M Y') : '' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="applicationdtl delerbox-border-b">
                    <div class="applicationdtl ">
                        <div class="section-title">FOR OFFICE USE ONLY</div>
                        @if (!empty($distributor_dealers->business_location))
                            <div class="row">
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Location of business/premises :</label>
                                        <span class="info-value">{{ $distributor_dealers->business_location }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="applicationdtl ">
                            <label class=" mb-1 godwn-cap">Godown capacity </label>
                            <div class="distributer-cls">
                                @if (!empty($distributor_dealers->godown_capacity_area))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">Area in sq. fee :</label>
                                            <span
                                                class="info-value">{{ $distributor_dealers->godown_capacity_area }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($distributor_dealers->godown_capacity_inbags))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">Capacity in bags :</label>
                                            <span
                                                class="info-value">{{ $distributor_dealers->godown_capacity_inbags }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($distributor_dealers->godown_construction))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label ">Construction :</label>
                                            <span class="info-value">
                                                @if ($distributor_dealers->godown_construction == 'Permanent')
                                                    Permanent
                                                @else
                                                    Temporary
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($distributor_dealers->experience_capability))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">Experience and capability :</label>
                                            <span
                                                class="info-value">{{ $distributor_dealers->experience_capability }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($distributor_dealers->financial_capability))
                                    <div class="info-row">
                                        <div class="mb-3">
                                            <label class="col-form-label">Financial standing and capability to
                                                invest :
                                            </label>
                                            <span
                                                class="info-value">{{ $distributor_dealers->financial_capability }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="info-row">
                            <div class="mb-3">
                                <label class="col-form-label">Market reputation and credibility :
                                </label>
                                <span class="info-value">
                                    @if ($distributor_dealers->market_reputation == 'Excellent')
                                        Excellent
                                    @elseif ($distributor_dealers->market_reputation == 'Very Good')
                                        Very Good
                                    @elseif ($distributor_dealers->market_reputation == 'Good')
                                        Good
                                    @elseif ($distributor_dealers->market_reputation == 'Average')
                                        Average
                                    @else
                                        Poor
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="distributer-cls">
                            @if (!empty($distributor_dealers->business_potential))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Business potential of party (Estimated
                                            sales/month) :</label>
                                        <span class="info-value">{{ $distributor_dealers->business_potential }}</span>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->market_potential))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Total market potential of the area :</label>
                                        <span class="info-value">{{ $distributor_dealers->market_potential }}</span>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->minimum_turnover))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Assurance of minimum turnover :</label>
                                        <span class="info-value">{{ $distributor_dealers->minimum_turnover }}</span>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->competitor_count))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Approximate number of competitors stockists
                                            in
                                            the area/town (major competitors) :</label>
                                        <span class="info-value">{{ $distributor_dealers->competitor_count }}</span>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->cr_limit))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Credit limit :</label>
                                        <span class="info-value">{{ $distributor_dealers->cr_limit }}</span>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->credit_limit))
                                <div class="info-row">
                                    <label class="col-form-label">Payment Reminder :</label>
                                    <span class="info-value">{{ $distributor_dealers->credit_limit }}
                                        {{ $distributor_dealers->credit_limit_type == 'day' ? 'Days' : 'Months' }}</span>
                                </div>
                            @endif
                            @if (!empty($distributor_dealers->remarks))
                                <div class="info-row">
                                    <div class="mb-3">
                                        <label class="col-form-label">Remarks (if any) :</label>
                                        <span class="info-value">{{ $distributor_dealers->remarks }}</span>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-lg-12">
                            <label class="section-title fw-bold">All Documents:</label>
                            <div class="border p-3 rounded bg-light">
                                @if ($distributor_dealers->documents->count())
                                    <div class="row gc-dd-document">
                                        @foreach ($distributor_dealers->documents as $document)
                                            @php
                                                $extension = strtolower(
                                                    pathinfo($document->file_name, PATHINFO_EXTENSION),
                                                );
                                                $fileUrl = asset('storage/' . $document->file_path);
                                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                $downloadTypes = ['doc', 'docx'];
                                                $openInTab = !in_array($extension, $downloadTypes);
                                                $icon = match ($extension) {
                                                    'pdf' => 'bi-file-earmark-pdf',
                                                    'doc', 'docx' => 'bi-file-earmark-word',
                                                    'xls', 'xlsx' => 'bi-file-earmark-excel',
                                                    default => 'bi-file-earmark',
                                                };
                                            @endphp
                                            <div class="col-md-2 col-sm-4 mb-3">
                                                <div class="border rounded p-2 h-100 bg-white shadow-sm">
                                                    <div class="fw-semibold mb-2">{{ $loop->iteration }}.
                                                    </div>
                                                    @if ($isImage)
                                                        <a href="{{ $fileUrl }}" target="_blank"
                                                            class="d-block mb-2">
                                                            <img src="{{ $fileUrl }}"
                                                                alt="{{ $document->file_name }}"
                                                                class="img-thumbnail" style="max-height: 100px;">
                                                        </a>
                                                    @else
                                                        @if ($openInTab)
                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                                class="text-primary d-flex align-items-center mb-2">
                                                                <i class="bi {{ $icon }} fs-4 me-2"></i>
                                                                {{ $document->file_name }}
                                                            </a>
                                                        @else
                                                            <a href="{{ $fileUrl }}"
                                                                download="{{ $document->file_name }}"
                                                                class="text-success d-flex align-items-center mb-2">
                                                                <i class="bi {{ $icon }} fs-4 me-2"></i>
                                                                {{ $document->file_name }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                    {{-- <button type="button"
                                    class="btn btn-sm btn-danger delete_document"
                                    data-id="{{ $document->id }}"
                                data-url="{{ route('distributors_dealers.documents_destroy', $document->id) }}">
                                <i class="ti ti-trash text-white"></i> Delete
                                </button> --}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No documents uploaded.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--
      <div class="d-flex align-items-center justify-content-end">
         <button type="submit" class="btn btn-primary">Update</button>
      </div>
      --}}

        </div>
