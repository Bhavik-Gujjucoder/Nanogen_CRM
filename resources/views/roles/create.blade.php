@extends('layouts.main')

@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="">
    <div class="">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 col-md-6">
                            <label>Role Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 ">
                            <label>Permissions</label><br>
                            @foreach ($permissions as $permission)
                                <div class="col-lg-2 col-md-4">
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" id="{{$permission->id}}" type="checkbox" name="permissions[]" style="border : 1px solid #0303038a"
                                            value="{{ $permission->name }}">

                                        <label class="form-check-label" for="{{ $permission->id }}">{{ $permission->name }} </label>
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
