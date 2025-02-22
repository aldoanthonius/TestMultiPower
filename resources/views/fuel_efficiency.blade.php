@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Efisiensi Bahan Bakar</h2>
    <form action="{{ route('fuel.efficiency.update') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <select name="vehicle_id" class="form-control">
                    <option value="">Pilih Kendaraan</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="distance_traveled" class="form-control" placeholder="Jarak Tempuh (km)" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="fuel_used" class="form-control" placeholder="Bahan Bakar (liter)" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
    <form method="GET" action="{{ url('/fuel-efficiency') }}" class="mb-4">
        <div class="d-flex gap-2">
            <input type="text" name="search" placeholder="Cari kendaraan..." value="{{ request('search') }}"
                class="form-control w-25">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ url('/fuel-efficiency') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Kendaraan</th>
                <th>Jarak Tempuh (km)</th>
                <th>Bahan Bakar Digunakan (liter)</th>
                <th>Efisiensi (km/liter)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->distance_traveled ?? '-' }}</td>
                    <td>{{ $vehicle->fuel_used ?? '-' }}</td>
                    <td>
                        @if ($vehicle->fuel_used > 0)
                            {{ number_format($vehicle->distance_traveled / $vehicle->fuel_used, 2) }} km/l
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
</div>


@endsection
