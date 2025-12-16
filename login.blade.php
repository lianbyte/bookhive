@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<h4 class="mb-4 text-center">Sign In</h4>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" required>
        </div>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Remember me</label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </div>
</form>

<hr class="my-4">

<p class="text-center mb-0">
    Don't have an account? <a href="{{ route('register') }}">Register here</a>
</p>

<div class="mt-4 p-3 bg-light rounded">
    <p class="mb-2 small text-muted"><strong>Demo Accounts:</strong></p>
    <p class="mb-1 small"><strong>Admin:</strong> admin@bookhive.com / password</p>
    <p class="mb-1 small"><strong>Librarian:</strong> librarian@bookhive.com / password</p>
    <p class="mb-0 small"><strong>Member:</strong> member@bookhive.com / password</p>
</div>
@endsection
