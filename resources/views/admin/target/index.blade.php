@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection

<div class="card">
    <div class="card-header">
        <!-- Search -->
        <div class="row align-items-center">
            <div class="col-sm-4">
                <div class="icon-form mb-3 mb-sm-0">
                    <span class="form-icon"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search Contacts">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                    <div class="dropdown me-2">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-package-export me-2"></i>Export</a>
                        <div class="dropdown-menu  dropdown-menu-end">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                            class="ti ti-file-type-pdf text-danger me-1"></i>Export
                                        as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                            class="ti ti-file-type-xls text-green me-1"></i>Export
                                        as Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary"
                   data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i
                   class="ti ti-square-rounded-plus me-2"></i>Add New Targets</a> -->
                    <a href="{{ route('target.create') }}" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add New Target</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- Projects List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="target_table">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" scope="col"><label class="checkboxs"><input type="checkbox"
                                    id="select-all"><span class="checkmarks"></span></label>
                        </th>
                        <th scope="col">ID</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Sales Person Name</th>
                        <th scope="col">Traget Value</th>
                        {{-- <th scope="col">Grade</th> --}}
                        <th scope="col">Region</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th class="text-end" scope="col">Action</th>
                    </tr>
                </thead>

            </table>
        </div>

        <!-- /Projects List -->
    </div>
</div>

@endsection
@section('script')
<script>
    /***** DataTable *****/
    var target_show = $('#target_table').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [1, 'desc']
        ],
        ajax: "{{ route('target.index') }}",
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'subject',
                name: 'subject',
                searchable: true
            },
            {
                data: 'salesman_id',
                name: 'salesman_id',
                searchable: true
            },
            {
                data: 'target_value',
                name: 'target_value',
                searchable: true,
                orderable: false
            },
            {
                data: 'city_id',
                name: 'city_id',
                searchable: true,
                orderable: false
            },
            {
                data: 'start_date',
                name: 'start_date',
                searchable: true
            },
            {
                data: 'end_date',
                name: 'end_date',
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
    });
</script>
@endsection
