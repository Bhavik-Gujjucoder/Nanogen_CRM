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
                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">

                    <a href="javascript:void(0)" id="openModal" class="btn btn-primary"><i
                            class="ti ti-square-rounded-plus me-2"></i>Add Grade</a>
                </div>
            </div>
        </div>
        <!-- /Search -->
    </div>
    <div class="card-body">

        <!-- Manage Users List -->
        <div class="table-responsive custom-table">
            <table class="table dataTable no-footer" id="users">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th class="text-end" scope="col">Action</th>
                    </tr>
                </thead>

            </table>
        </div>

        <!-- /Manage Users List -->
    </div>
</div>
<!--  Single Modal for Add & Edit -->
<div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Grade</h5>
                <button type="button" class="btn-close close_poup" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="adminForm">
                    @csrf
                    <input type="hidden" name="user_id">

                    <div class="mb-3">
                        <label>Grade Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Grade name">
                        <span class="name_error"></span>
                    </div>

                    <div class="float-end">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        <button type="button" class="btn btn-light me-2 close_poup"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary" id="submitBtn">Create</button> --}}
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var grade_table = $('#users').DataTable({
        "pageLength": 10,
        deferRender: true, // Prevents unnecessary DOM rendering
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('grade.index') }}",
        columns: [{
                data: 'id',
                name: 'id',
                searchable: true
            }, {
                data: 'name',
                name: 'name',
                searchable: true
            },
            {
                data: 'status',
                name: 'status',
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

    // Custom Search Box
    $('#customSearch').on('keyup', function() {
        grade_table.search(this.value).draw();
    });




    //  Open Modal for Adding a New Grade
    $('#openModal').click(function() {
        $('#adminForm')[0].reset();
        $('#modalTitle').text('Add Grade');
        $('#submitBtn').text('Create');
        $('input[name="user_id"]').val('');
        $('#adminModal').modal('show');
        $("#adminForm .text-danger").text('');
        $('#adminForm').find('.is-invalid').removeClass('is-invalid');

    });

    //  Open Modal for Editing an Admin
    $(document).on('click', '.edit-btn', function() {
        let user_id = $(this).data('id');
        $("#adminForm .text-danger").text('');
        $('#adminForm').find('.is-invalid').removeClass('is-invalid');

        $.get('{{ route('grade.edit', ':id') }}'.replace(':id', user_id), function(user) {
            $('#modalTitle').text('Edit Grade');
            $('#submitBtn').text('Update');
            $('input[name="user_id"]').val(user_id);
            $('input[name="name"]').val(user.name);
            $('#adminModal').modal('show');
        });
    });

    //  Handle Add & Edit Form Submission
    $('#adminForm').submit(function(e) {
        e.preventDefault();
        let user_id = $('input[name="user_id"]').val();
        let url = user_id ? '{{ route('grade.update', ':id') }}'.replace(':id', user_id) :
            "{{ route('grade.store') }}";
        let method = user_id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize() + "&_method=" + method,
            success: function(response) {
                $('#adminModal').modal('hide');
                grade_table.ajax.reload();
                show_success(response.message);
            },
            error: function(response) {
                display_errors(response.responseJSON.errors);
                // show_error('Error occurred!');
            }
        });
    });

    $(document).on('click', '.deleteGrade', function(event) {
        event.preventDefault();
        let userId = $(this).data('id'); // Get the user ID
        let form = $('#delete-form-' + userId); // Select the correct form
        console.log(form);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this Grade? Once deleted, it cannot be recovered.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'my-custom-popup', // Custom class for the popup
                title: 'my-custom-title', // Custom class for the title
                confirmButton: 'btn btn-primary', // Custom class for the confirm button
                cancelButton: 'btn btn-secondary', // Custom class for the cancel button
                icon: 'my-custom-icon swal2-warning'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form if confirmed
            }
        });
    });

    function display_errors(errors) {
        $("#adminForm .error-text").text('');
        $.each(errors, function(key, value) {
            $('input[name=' + key + ']').addClass('is-invalid');
            $('.' + key + '_error').text(value[0]).addClass('text-danger');
        });
    }

    // $(".dataTables_filter").hide();
    // $(".dataTables_length").hide();
</script>
@endsection
