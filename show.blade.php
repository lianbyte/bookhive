@extends('layouts.app')

@section('title', $user->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                @if($user->role === 'admin')
                    <span class="badge bg-danger">Admin</span>
                @elseif($user->role === 'librarian')
                    <span class="badge bg-primary">Librarian</span>
                @else
                    <span class="badge bg-secondary">Member</span>
                @endif
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">Contact Information</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th class="text-muted">Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Phone</th>
                        <td>{{ $user->phone ?? 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Address</th>
                        <td>{{ $user->address ?? 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Joined</th>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if(Auth::user()->isAdmin())
        <div class="card">
            <div class="card-body">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-pencil me-1"></i>Edit User
                </a>
                @if($user->id !== Auth::id())
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to delete this user?')">
                        <i class="bi bi-trash me-1"></i>Delete User
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-8">
        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <h3 class="mb-0 text-primary">{{ $stats['active_borrows'] }}</h3>
                        <small class="text-muted">Active Borrows</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <h3 class="mb-0 text-danger">{{ $stats['overdue_borrows'] }}</h3>
                        <small class="text-muted">Overdue</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <h3 class="mb-0 text-info">{{ $stats['total_borrowed'] }}</h3>
                        <small class="text-muted">Total Borrowed</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Borrows -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>Recent Borrow History
            </div>
            <div class="card-body p-0">
                @if($user->borrowRecords->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Borrowed</th>
                                <th>Due Date</th>
                                <th>Returned</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->borrowRecords as $record)
                            <tr>
                                <td>
                                    <a href="{{ route('books.show', $record->book) }}" class="text-decoration-none">
                                        {{ Str::limit($record->book->title, 25) }}
                                    </a>
                                </td>
                                <td>{{ $record->borrow_date->format('M d, Y') }}</td>
                                <td>{{ $record->due_date->format('M d, Y') }}</td>
                                <td>{{ $record->return_date ? $record->return_date->format('M d, Y') : '-' }}</td>
                                <td><span class="badge badge-{{ $record->status }}">{{ ucfirst($record->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mb-0 mt-2">No borrow history</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
