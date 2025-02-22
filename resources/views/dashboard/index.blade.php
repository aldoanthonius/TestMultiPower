@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Dashboard Kendaraan</h1>
    <div class="d-flex gap-2 mb-3">
        <a href="{{ url('/dashboard/create') }}" class="btn btn-primary">Tambah Kendaraan</a>
        <a href="{{ route('notifications.index') }}" class="btn btn-warning">Cek Perawatan</a>
        <a href="{{ route('fuel.efficiency') }}" class="btn btn-info">Lihat Laporan Efisiensi</a>
        <a href="{{ route('maintenance_schedules.index') }}" class="btn btn-info">Lihat Jadwal Perawatan</a>

    </div>

    <form method="GET" action="{{ url('/dashboard') }}" class="mb-4">
        <div class="d-flex gap-2">
            <input type="text" name="search" placeholder="Cari kendaraan..." value="{{ request('search') }}"
                class="form-control w-25">

            <select name="status" class="form-select w-25">
                <option value="">Pilih Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>

            <input type="date" name="service_date" value="{{ request('service_date') }}"
                class="form-control w-25">

            <select name="sort_by" class="form-select w-25">
                <option value="">Urutkan</option>
                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Berdasarkan Status</option>
                <option value="last_maintenance" {{ request('sort_by') == 'last_maintenance' ? 'selected' : '' }}>
                    Berdasarkan Tanggal Servis
                </option>
                <option value="is_in_use" {{ request('sort_by') == 'is_in_use' ? 'selected' : '' }}>Berdasarkan Ketersediaan</option>
            </select>

            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nama Kendaraan</th>
                <th>Status</th>
                <th>Ketersediaan</th>
                <th>Terakhir Servis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->status }}</td>
                    <td>{{ $vehicle->is_in_use ? 'Sedang Dipakai' : 'Tidak Dipakai' }}</td>
                    <td>{{ $vehicle->last_maintenance }}</td>
                    <td>
                        <a href="{{ url('/dashboard/'.$vehicle->id.'/edit') }}" class="btn btn-warning">Edit</a>
                        <form action="{{ url('/dashboard/'.$vehicle->id.'/delete') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger delete-btn">Hapus</button>
                        </form>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                document.querySelectorAll(".delete-btn").forEach(button => {
                                    button.removeEventListener("click", handleDelete); // Pastikan event lama dihapus
                                    button.addEventListener("click", handleDelete);
                                });

                                function handleDelete(event) {
                                    event.stopPropagation(); // Mencegah event bubbling

                                    if (confirm("Apakah Anda yakin ingin menghapus kendaraan ini?")) {
                                        this.closest("form").submit();
                                    }
                                }
                            });
                        </script>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

