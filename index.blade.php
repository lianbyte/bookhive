@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Users Management</h1>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add User
    </a>
    @endif
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" placeholder="Search by name or email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="role">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="librarian" {{ request('role') == 'librarian' ? 'selected' : '' }}>Librarian</option>
                        <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body p-0">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === Auth::id())
                                        <span class="badge bg-info ms-1">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role === 'librarian')
                                <span class="badge bg-primary">Librarian</span>
                            @else
                                <span class="badge bg-secondary">Member</span>
                            @endif
                        </td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== Auth::id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-people fs-1 text-muted"></i>
            <h4 class="mt-3">No users found</h4>
            <p class="text-muted">Try adjusting your search criteria.</p>
        </div>
        @endif
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $users->withQueryString()->links() }}
</div>
@endsection
