@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('borrows.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> New Lending
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_books'] }}</h3>
                        <small class="text-muted">Total Books</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['available_copies'] }}</h3>
                        <small class="text-muted">Available Copies</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['active_borrows'] }}</h3>
                        <small class="text-muted">Active Borrows</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger me-3">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['overdue_borrows'] }}</h3>
                        <small class="text-muted">Overdue</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Borrows -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Recent Borrows</span>
                <a href="{{ route('borrows.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentBorrows->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Member</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBorrows as $borrow)
                            <tr>
                                <td>{{ Str::limit($borrow->book->title, 25) }}</td>
                                <td>{{ $borrow->user->name }}</td>
                                <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mb-0 mt-2">No recent borrows</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Overdue Books -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Overdue Books</span>
                <a href="{{ route('borrows.index', ['status' => 'overdue']) }}" class="btn btn-sm btn-outline-danger">View All</a>
            </div>
            <div class="card-body p-0">
                @if($overdueBorrows->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Member</th>
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overdueBorrows as $borrow)
                            <tr>
                                <td>{{ Str::limit($borrow->book->title, 25) }}</td>
                                <td>{{ $borrow->user->name }}</td>
                                <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                                <td><span class="text-danger">{{ $borrow->due_date->diffInDays(now()) }} days</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                    <p class="mb-0 mt-2">No overdue books</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Popular Books -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-star me-2"></i>Popular Books
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($popularBooks as $book)
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ route('books.show', $book) }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="book-cover-placeholder" style="height: 150px;">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 text-dark">{{ Str::limit($book->title, 20) }}</h6>
                                    <small class="text-muted">{{ $book->borrow_records_count }} borrows</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
