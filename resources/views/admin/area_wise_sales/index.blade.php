@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }} <br>
@endsection


<div class="card">
    <div class="card-header">
        <!-- Search -->
        <div class="row align-items-center">
            <div class="col-sm-4">
                <div class="icon-form mb-3 mb-sm-0">
                    <span class="form-icon"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search" id="customSearch">
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">
        <!-- Contact List -->
        <div class="table-responsive custom-table">
            <table class="table" id="area_wise">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Sr no</th>
                        <th scope="col">City Name</th>
                        <th scope="col">Sales Amount</th>
                        <th class="no-sort" scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var area_wise = $('#area_wise').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        order: [
            [0, 'desc']
        ],
        ajax: "{{ route('area_wise_sales.index') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'city_name',
                name: 'city_name',
                searchable: true
            },
            {
                data: 'amount',
                name: 'amount',
                searchable: false,
                orderable: false,
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],

        columnDefs: [{
                targets: 0, // Sr no
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sr. No.');
                }
            },
            {
                targets: 1, // City Name
                createdCell: function(td) {
                    $(td).attr('data-label', 'City Name');
                }
            },
            {
                targets: 2, // Sales Amount
                createdCell: function(td) {
                    $(td).attr('data-label', 'Sales Amount');
                }
            },
            {
                targets: 3, // Action
                createdCell: function(td) {
                    $(td).attr('data-label', 'Action');
                }
            }
        ]


    });

    /***** Search Box *****/
    $('#customSearch').on('keyup', function() {
        area_wise.search(this.value).draw();
    });
</script>
@endsection
