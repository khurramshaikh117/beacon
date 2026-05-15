@extends('layouts.app')
@section('title', 'Operations — HRMS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Operations</h1>
        <p class="text-muted mb-0 small">Manage operational users (CRUD)</p>
    </div>
    <a href="{{ route('operations.create') }}" class="btn hrms-btn-primary text-white">
        <i class="bi bi-plus-lg me-1"></i> Add User
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Created</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                @forelse ($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td class="fw-semibold">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->created_at?->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('operations.edit', $u) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('operations.destroy', $u) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this user?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No users yet. Click "Add User".</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection
