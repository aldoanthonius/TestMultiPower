<!-- resources/views/dashboard/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kendaraan</h1>
    <form action="{{ url('/dashboard/'.$vehicle->id.'/update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Kendaraan</label>
            <input type="text" name="name" class="form-control" value="{{ $vehicle->name }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif">Aktif</option>
                <option value="rusak">Rusak</option>
                <option value="servis">Dalam Servis</option>
            </select>
        </div>
        <div class="form-group">
            <label for="is_in_use">Sedang Dipakai?</label>
            <select name="is_in_use" id="is_in_use" class="form-control">
                <option value="1">Ya</option>
                <option value="0" selected>Tidak</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Terakhir Servis</label>
            <input type="date" name="last_maintenance" class="form-control" value="{{ $vehicle->last_maintenance }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
