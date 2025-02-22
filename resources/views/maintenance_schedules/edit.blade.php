@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('maintenance_schedules.update', $maintenance_schedule) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="scheduled_date" class="form-label">Tanggal Perawatan</label>
        <input type="date" name="scheduled_date" class="form-control" value="{{ old('scheduled_date', $maintenance_schedule->scheduled_date) }}" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="scheduled" {{ $maintenance_schedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="completed" {{ $maintenance_schedule->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $maintenance_schedule->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('maintenance_schedules.index') }}" class="btn btn-secondary">Kembali</a>
</form>


@endsection
