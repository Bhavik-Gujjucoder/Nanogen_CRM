@extends('layouts.main')

@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="card">
    <div class="card-body">
        <div class="row">

            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <form action="{{ route('roles.update', $role->id) }}" method="POST" id="roleForm">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label>Role Name : </label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" >
                    {{-- <strong> {{ $role->name }}</strong> --}}
                    @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Permissions</label><br>
                    @foreach ($permissions as $permission)
                        <div class="col-lg-2 col-md-4">
                            <div class="form-check form-check-md d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    value="{{ $permission->name }}" id="{{ $permission->id }}"
                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                    style="border : 1px solid #0303038a">
                                <label class="form-check-label" for="{{ $permission->id }}">{{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#roleForm').validate({
                rules: {
                   
                    'permissions[]': {
                        required: true
                    }
                },
                messages: {
                   
                    'permissions[]': {
                        required: "Please select at least one permission"
                    }
                },
                 errorElement: 'span',
                errorClass: 'text-danger', // Add Bootstrap class
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "permissions[]") {
                        error.insertAfter(element.closest('.mb-3')); // Group error after checkbox area
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endsection