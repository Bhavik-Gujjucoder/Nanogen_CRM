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
            <input type="text" class="form-control" id="customSearch" placeholder="Search User">
            </div>
        </div>
        <div class="col-sm-8">
            <div
            class="d-flex align-items-center flex-wrap row-gap-2 column-gap-1 justify-content-sm-end">
            <div class="dropdown me-2">
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
                <a href="{{ route('complain.create')}}" class="btn btn-primary"><i
                class="ti ti-square-rounded-plus me-2"></i>Complain</a>
            </div>
        </div>
    </div>
    <!-- /Search -->
    </div>
    <div class="card-body">
    <!-- /Filter -->
    <!-- dealers Users List -->
    <div class="table-responsive custom-table">
        <table class="table dataTable no-footer" id="complain">
            <thead class="thead-light">
            <tr>
                <th hidden>ID</th>
                <th class="no-sort" scope="col">
                    <label class="checkboxs">
                        <input type="checkbox" id="select-all" class="complain_checkbox"><span class="checkmarks"></span>
                    </label>
                </th>
                <th  scope="col">Dealer/Distributor</th>
                <th  scope="col">Date</th>
                <th  scope="col">Products </th>
                <th  scope="col">Status </th>
                <th  scope="col">Remarks</th>
                <th  scope="col">Action</th>
            </tr>
            </thead>
        </table>
    </div>
    
    </div>
    </div>
@endsection
@section('script')
<script>
     var complain_table = $('#complain').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [[0, 'desc']],  
        ajax: "{{ route('complain.index') }}",
        columns: [
            { data: 'id', name: 'id', visible: false, searchable: false },
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'dd_id',
                searchable: true
            },
            {
                data: 'date',
                name: 'date',
                searchable: true
            },
            {
                data: 'product',
                name: 'product_id',
                searchable: true
            },
            {
                data: 'status',
                name: 'status',
                searchable: true
            },
            {
                data: 'remark',
                name: 'remark',
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

    /***** Bulk Delete *****/
    $('#select-all').change(function() {
        // Check/uncheck all checkboxes when the select-all checkbox is clicked
        $('.complain_checkbox').prop('checked', this.checked);
    });

    // Custom Search Box
    $('#customSearch').on('keyup', function() {
        complain_table.search(this.value).draw();
    });
</script>
@endsection