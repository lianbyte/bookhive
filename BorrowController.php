<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Display a listing of all borrow records.
     */
    public function index(Request $request)
    {
        $query = BorrowRecord::with(['user', 'book']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by user (for staff)
        if ($request->has('user_id') && $request->user_id && Auth::user()->isStaff()) {
            $query->where('user_id', $request->user_id);
        }

        // For members, show only their own records
        if (Auth::user()->isMember()) {
            $query->where('user_id', Auth::id());
        }

        $borrows = $query->latest()->paginate(15);
        $users = Auth::user()->isStaff() ? User::where('role', 'member')->get() : collect();

        return view('borrows.index', compact('borrows', 'users'));
    }

    /**
     * Show the form for creating a new borrow record.
     */
    public function create(Request $request)
    {
        $book = null;
        if ($request->has('book_id')) {
            $book = Book::findOrFail($request->book_id);
        }

        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();
        $users = Auth::user()->isStaff() 
            ? User::where('role', 'member')->orderBy('name')->get() 
            : collect([Auth::user()]);

        return view('borrows.create', compact('books', 'users', 'book'));
    }

    /**
     * Store a newly created borrow record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Check if book is available
        if (!$book->isAvailable()) {
            return back()->with('error', 'This book is not available for borrowing.');
        }

        // Check if user already has this book borrowed
        $existingBorrow = BorrowRecord::where('user_id', $validated['user_id'])
            ->where('book_id', $validated['book_id'])
            ->where('status', 'borrowed')
            ->first();

        if ($existingBorrow) {
            return back()->with('error', 'This user already has this book borrowed.');
        }

        // Create borrow record
        BorrowRecord::create([
            'user_id' => $validated['user_id'],
            'book_id' => $validated['book_id'],
            'borrow_date' => now(),
            'due_date' => $validated['due_date'],
            'status' => 'borrowed',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Decrease available copies
        $book->decrement('available_copies');

        return redirect()->route('borrows.index')->with('success', 'Book borrowed successfully!');
    }

    /**
     * Display the specified borrow record.
     */
    public function show(BorrowRecord $borrow)
    {
        // Check if user can view this record
        if (Auth::user()->isMember() && $borrow->user_id !== Auth::id()) {
            abort(403);
        }

        return view('borrows.show', compact('borrow'));
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook(BorrowRecord $borrow)
    {
        // Check if user can return this book
        if (Auth::user()->isMember() && $borrow->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrow->status !== 'borrowed') {
            return back()->with('error', 'This book has already been returned.');
        }

        // Update borrow record
        $borrow->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        // Increase available copies
        $borrow->book->increment('available_copies');

        return redirect()->route('borrows.index')->with('success', 'Book returned successfully!');
    }

    /**
     * Display user's borrowed books.
     */
    public function myBorrows()
    {
        $borrows = BorrowRecord::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('borrows.my-borrows', compact('borrows'));
    }

    /**
     * Update overdue status for all borrow records.
     */
    public static function updateOverdueStatus()
    {
        BorrowRecord::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);
    }
}
