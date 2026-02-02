@extends('layouts.main')
@section('content')
@section('title')
    {{ $page_title }}
@endsection
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"> {{ $page_title }}</h5>
                </div>

                <div class="card-body">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('distributors.dealers.import') }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Select Excel File</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Import
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
