@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome, {{ Auth::user()->name }}!</h1>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100 border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['active_borrows'] }}</h3>
                        <small class="text-muted">Currently Borrowed</small>
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
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['returned_books'] }}</h3>
                        <small class="text-muted">Returned</small>
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
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_borrowed'] }}</h3>
                        <small class="text-muted">Total Borrowed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Active Borrows -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-journal-bookmark me-2"></i>My Current Borrows</span>
                <a href="{{ route('my-borrows') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($activeBorrows->count() > 0)
                    @foreach($activeBorrows as $borrow)
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                        @if($borrow->book->cover_image)
                            <img src="{{ asset('storage/' . $borrow->book->cover_image) }}" alt="{{ $borrow->book->title }}" class="me-3" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div class="me-3 d-flex align-items-center justify-content-center bg-primary text-white" style="width: 50px; height: 70px; border-radius: 4px;">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $borrow->book->title }}</h6>
                            <small class="text-muted">by {{ $borrow->book->author }}</small>
                            <div class="mt-1">
                                <span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span>
                                <small class="text-muted ms-2">Due: {{ $borrow->due_date->format('M d, Y') }}</small>
                            </div>
                        </div>
                        @if($borrow->status === 'borrowed')
                        <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="ms-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Return this book?')">
                                <i class="bi bi-check"></i> Return
                            </button>
                        </form>
                        @endif
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mb-0 mt-2">You have no active borrows</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary mt-3">Browse Books</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Available Books -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-book me-2"></i>Recently Added Books</span>
                <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-primary">Browse All</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($recentBooks as $book)
                    <div class="col-6">
                        <a href="{{ route('books.show', $book) }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 120px; object-fit: cover;">
                                @else
                                    <div class="book-cover-placeholder" style="height: 120px; font-size: 2rem;">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 text-dark small">{{ Str::limit($book->title, 25) }}</h6>
                                    <small class="text-muted">{{ Str::limit($book->author, 20) }}</small>
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
