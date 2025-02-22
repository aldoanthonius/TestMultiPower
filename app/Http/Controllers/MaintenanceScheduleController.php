<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;

class MaintenanceScheduleController extends Controller{
    // agar semua method hanya bisa diakses oleh user yang login
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $schedules = MaintenanceSchedule::with('vehicle')->orderBy('scheduled_date', 'asc')->get();
        return view('maintenance_schedules.index', compact('schedules'));
    }

    public function create() {
        // hanya kendaraan status rusak yang bisa bikin jadwal
        $vehicles = Vehicle::where('status', 'rusak')->get();
        return view('maintenance_schedules.create', compact('vehicles'));
    }

    public function store(Request $request) {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'scheduled_date' => 'required|date|after:today',
        ]);

        MaintenanceSchedule::create([
            'vehicle_id' => $request->vehicle_id,
            'scheduled_date' => $request->scheduled_date,
            'status' => 'scheduled',
        ]);

        return redirect()->route('maintenance_schedules.index')->with('success', 'Jadwal perawatan berhasil ditambahkan!');
    }

    public function edit(MaintenanceSchedule $maintenance_schedule) {
        return view('maintenance_schedules.edit', compact('maintenance_schedule'));
    }

    public function update(Request $request, MaintenanceSchedule $maintenance_schedule) {
        $request->validate([
            'scheduled_date' => 'required|date|after:today',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $maintenance_schedule->update($request->all());

        return redirect()->route('maintenance_schedules.index')->with('success', 'Jadwal perawatan berhasil diperbarui!');
    }


    public function destroy(MaintenanceSchedule $schedule) {
        $schedule->delete();
        return redirect()->route('maintenance_schedules.index')->with('success', 'Jadwal perawatan berhasil dihapus!');
    }
}
