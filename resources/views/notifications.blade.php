@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Notifikasi Perawatan</h2>

    @if($notifications->isNotEmpty())
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item">
                    🚨 {{ $notification->message }}
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-success">
            ✅ Semua kendaraan dalam kondisi baik!
        </div>
    @endif
</div>
<a href="{{ url('/dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>


@endsection


    
