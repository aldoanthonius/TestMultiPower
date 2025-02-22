@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🛠 Jadwal Perawatan Kendaraan</h2>

    <a href="{{ route('maintenance_schedules.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

    @if($schedules->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Kendaraan</th>
                    <th>Tanggal Perawatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->vehicle->name }}</td>
                        <td>{{ $schedule->scheduled_date }}</td>
                        <td>{{ ucfirst($schedule->status) }}</td>
                        <td>
                            <a href="{{ route('maintenance_schedules.edit', $schedule->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('maintenance_schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-success">✅ Tidak ada jadwal perawatan.</div>
    @endif
</div>

<a href="{{ url('/dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
@endsection
