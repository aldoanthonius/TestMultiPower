@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🔐 Login</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
        <a href="{{ url('/register') }}" class="btn btn-link">Belum punya akun? Daftar</a>
    </form>
</div>
@endsection
