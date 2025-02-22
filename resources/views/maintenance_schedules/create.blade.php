@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🛠 Tambah Jadwal Perawatan</h2>

    <form method="POST" action="{{ route('maintenance_schedules.store') }}">
        @csrf
        <div class="mb-3">
            <label for="vehicle_id" class="form-label">Pilih Kendaraan</label>
            <select name="vehicle_id" class="form-control" required>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="scheduled_date" class="form-label">Tanggal Perawatan</label>
            <input type="date" name="scheduled_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('maintenance_schedules.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
