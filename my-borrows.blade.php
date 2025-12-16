@extends('layouts.app')

@section('title', 'My Borrows')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">My Borrowed Books</h1>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($borrows->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrows as $borrow)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($borrow->book->cover_image)
                                    <img src="{{ asset('storage/' . $borrow->book->cover_image) }}" alt="{{ $borrow->book->title }}" class="me-3" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div class="me-3 d-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 55px; border-radius: 4px;">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('books.show', $borrow->book) }}" class="text-decoration-none fw-bold">
                                        {{ Str::limit($borrow->book->title, 30) }}
                                    </a>
                                    <br><small class="text-muted">{{ $borrow->book->author }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                        <td>
                            {{ $borrow->due_date->format('M d, Y') }}
                            @if($borrow->status === 'borrowed' && $borrow->due_date->isPast())
                                <br><small class="text-danger">{{ $borrow->due_date->diffForHumans() }}</small>
                            @elseif($borrow->status === 'borrowed')
                                <br><small class="text-muted">{{ $borrow->due_date->diffForHumans() }}</small>
                            @endif
                        </td>
                        <td>{{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : '-' }}</td>
                        <td><span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span></td>
                        <td>
                            @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                            <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Return this book?')">
                                    <i class="bi bi-check-circle"></i> Return
                                </button>
                            </form>
                            @else
                            <span class="text-muted">Completed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-journal-bookmark fs-1 text-muted"></i>
            <h4 class="mt-3">No borrowed books</h4>
            <p class="text-muted">You haven't borrowed any books yet.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary">
                <i class="bi bi-book me-1"></i> Browse Books
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $borrows->links() }}
</div>
@endsection
