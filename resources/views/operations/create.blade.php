@extends('layouts.app')
@section('title', 'Add User — HRMS')

@section('content')
<h1 class="h4 fw-bold mb-3">Add User</h1>
<div class="card border-0 shadow-sm" style="max-width:560px">
    <div class="card-body">
        <form method="POST" action="{{ route('operations.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Name</label>
                <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button class="btn hrms-btn-primary text-white">Create</button>
                <a href="{{ route('operations.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
