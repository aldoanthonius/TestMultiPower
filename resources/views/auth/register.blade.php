@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📝 Register</h2>

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Register</button>
        <a href="{{ url('/login') }}" class="btn btn-link">Sudah punya akun? Login</a>
    </form>
</div>
@endsection
