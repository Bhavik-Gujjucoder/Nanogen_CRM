@extends('layouts.main')

@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="container">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Role Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Permissions</label><br>
                            @foreach ($permissions as $permission)
                                <div class="col-lg-2 col-md-4">
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permission->name }}">

                                        <label class="form-check-label" for="Sales Persons">{{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
