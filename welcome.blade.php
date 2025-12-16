<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookHive - Library Management System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root { --primary-color: #6366f1; --secondary-color: #4f46e5; --accent-color: #f59e0b; }
        .hero-section { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); min-height: 100vh; color: white; position: relative; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%236366f1' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .navbar { background: transparent !important; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .navbar-brand i { color: var(--accent-color); }
        .hero-content { position: relative; z-index: 1; }
        .hero-title { font-size: 3.5rem; font-weight: 800; line-height: 1.2; }
        .hero-subtitle { font-size: 1.25rem; color: #94a3b8; }
        .btn-hero { padding: 0.75rem 2rem; font-size: 1.1rem; border-radius: 0.5rem; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--secondary-color); border-color: var(--secondary-color); }
        .feature-card { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 1rem; padding: 2rem; transition: transform 0.3s, background 0.3s; }
        .feature-card:hover { transform: translateY(-5px); background: rgba(255, 255, 255, 0.1); }
        .feature-icon { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
        .stats-section { background: rgba(255, 255, 255, 0.03); border-top: 1px solid rgba(255, 255, 255, 0.1); border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: var(--accent-color); }
        .footer { background: #0f172a; color: #64748b; }
        @media (max-width: 768px) { .hero-title { font-size: 2.5rem; } }
    </style>
</head>
<body>
    <div class="hero-section">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-book-half"></i> BookHive</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">Browse Books</a></li>
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="btn btn-primary ms-2" href="{{ route('register') }}">Get Started</a></li>
                        @else
                            <li class="nav-item"><a class="btn btn-primary ms-2" href="{{ route('dashboard') }}">Dashboard</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container hero-content">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-6">
                    <h1 class="hero-title mb-4">Your Digital Library<br><span style="color: var(--accent-color);">Management Solution</span></h1>
                    <p class="hero-subtitle mb-4">BookHive makes it easy to manage your library's book collection, track borrowings, and serve your members efficiently. A modern solution for modern libraries.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-hero"><i class="bi bi-rocket-takeoff me-2"></i>Get Started Free</a>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-light btn-hero"><i class="bi bi-book me-2"></i>Browse Catalog</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center"><i class="bi bi-book-half" style="font-size: 15rem; opacity: 0.1;"></i></div>
            </div>
        </div>

        <div class="container pb-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-collection"></i></div>
                        <h4>Book Management</h4>
                        <p class="text-muted mb-0">Easily catalog and organize your entire book collection with detailed information and cover images.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-journal-bookmark"></i></div>
                        <h4>Lending Tracking</h4>
                        <p class="text-muted mb-0">Track book borrowings, due dates, and returns. Get alerts for overdue books automatically.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <h4>Member Management</h4>
                        <p class="text-muted mb-0">Manage library members, track their borrowing history, and provide personalized service.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-section py-5">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-4 mb-md-0"><div class="stat-number">{{ \App\Models\Book::count() }}</div><div class="text-muted">Books Available</div></div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0"><div class="stat-number">{{ \App\Models\User::where('role', 'member')->count() }}</div><div class="text-muted">Active Members</div></div>
                    <div class="col-md-3 col-6"><div class="stat-number">{{ \App\Models\BorrowRecord::count() }}</div><div class="text-muted">Books Borrowed</div></div>
                    <div class="col-md-3 col-6"><div class="stat-number">{{ \App\Models\Book::distinct('category')->count('category') }}</div><div class="text-muted">Categories</div></div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer py-4"><div class="container text-center"><p class="mb-0"><i class="bi bi-book-half me-2" style="color: var(--accent-color);"></i>BookHive &copy; {{ date('Y') }} - Library Management System</p></div></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
