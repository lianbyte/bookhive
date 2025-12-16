<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Update overdue status
        BorrowController::updateOverdueStatus();

        $user = Auth::user();

        if ($user->isStaff()) {
            return $this->staffDashboard();
        }

        return $this->memberDashboard();
    }

    /**
     * Staff dashboard with overview statistics.
     */
    private function staffDashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_copies' => Book::sum('total_copies'),
            'available_copies' => Book::sum('available_copies'),
            'total_members' => User::where('role', 'member')->count(),
            'active_borrows' => BorrowRecord::where('status', 'borrowed')->count(),
            'overdue_borrows' => BorrowRecord::where('status', 'overdue')->count(),
            'returned_today' => BorrowRecord::whereDate('return_date', today())->count(),
            'borrowed_today' => BorrowRecord::whereDate('borrow_date', today())->count(),
        ];

        $recentBorrows = BorrowRecord::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        $overdueBorrows = BorrowRecord::with(['user', 'book'])
            ->where('status', 'overdue')
            ->latest()
            ->take(5)
            ->get();

        $popularBooks = Book::withCount(['borrowRecords'])
            ->orderByDesc('borrow_records_count')
            ->take(5)
            ->get();

        return view('dashboard.staff', compact('stats', 'recentBorrows', 'overdueBorrows', 'popularBooks'));
    }

    /**
     * Member dashboard with personal borrowing info.
     */
    private function memberDashboard()
    {
        $user = Auth::user();

        $stats = [
            'active_borrows' => $user->borrowRecords()->where('status', 'borrowed')->count(),
            'overdue_borrows' => $user->borrowRecords()->where('status', 'overdue')->count(),
            'total_borrowed' => $user->borrowRecords()->count(),
            'returned_books' => $user->borrowRecords()->where('status', 'returned')->count(),
        ];

        $activeBorrows = $user->borrowRecords()
            ->with('book')
            ->whereIn('status', ['borrowed', 'overdue'])
            ->latest()
            ->get();

        $recentBooks = Book::where('available_copies', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.member', compact('stats', 'activeBorrows', 'recentBooks'));
    }
}
