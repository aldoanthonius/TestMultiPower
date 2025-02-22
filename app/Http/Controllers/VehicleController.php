<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Vehicle;
use App\Models\MaintenanceNotification;

use Carbon\Carbon;

class VehicleController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request){
        $query = Vehicle::query();
        $notifications = MaintenanceNotification::all();
        // Filter berdasarkan nama kendaraan
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal servis
        if ($request->has('service_date') && !empty($request->service_date)) {
            $query->whereDate('last_maintenance', $request->service_date);
        }

        // Sorting berdasarkan status atau tanggal servis
        if ($request->has('sort_by')) {
            if ($request->sort_by == 'status') {
                $query->orderBy('status', 'asc');
            } elseif ($request->sort_by == 'last_maintenance') {
                $query->orderBy('last_maintenance', 'desc');
            } else if($request->sort_by == 'is_in_use'){
                $query->orderBy('is_in_use', 'desc');
            }
        }

        $vehicles = $query->paginate(10);

        return view('dashboard.index', compact('vehicles','notifications'));
    }

    public function create() {
        return view('dashboard.create');
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'last_maintenance' => 'required|date',
            'is_in_use' => 'required|boolean'
        ]);

        $vehicle = new Vehicle();
        $vehicle->name = $request->name;
        $vehicle->last_maintenance = $request->last_maintenance;
        $vehicle->is_in_use = $request->is_in_use;

        // Cek apakah sudah lebih dari 30 hari sejak servis terakhir
        $lastServiceDate = Carbon::parse($vehicle->last_maintenance);
        $daysSinceLastService = $lastServiceDate->diffInDays(Carbon::now());

        if ($daysSinceLastService > 30) {
            $vehicle->status = 'rusak';
        } else {
            $vehicle->status = 'aktif';
        }

        $vehicle->save(); // simpan data kendaraan

        // Buat / kirim ke log jika kendaraan langsung berstatus "rusak"
        if ($vehicle->status == 'rusak') {
            MaintenanceNotification::create([
                'vehicle_id' => $vehicle->id,
                'message' => "🚨 Kendaraan {$vehicle->name} membutuhkan perawatan segera! Sudah lebih dari 30 hari tidak diservis.",
            ]);
        }

        return redirect('/dashboard')->with('success', 'Kendaraan berhasil ditambahkan!');
    }


    public function edit(Vehicle $vehicle) {
        return view('dashboard.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle){
        $request->validate([
            'name' => 'required|string|max:255',
            'last_maintenance' => 'required|date',
            'efficiency' => 'nullable|numeric',
            'is_in_use'=> 'required'
        ]);

        $vehicle->name = $request->name;
        $vehicle->last_maintenance = $request->last_maintenance;
        $vehicle->is_in_use = $request->is_in_use;

        // Cek apakah sudah lebih dari 30 hari sejak servis terakhir
        $lastServiceDate = Carbon::parse($vehicle->last_maintenance);
        $daysSinceLastService = $lastServiceDate->diffInDays(Carbon::now());

        if ($daysSinceLastService > 30) {
            $vehicle->status = 'rusak';
        } else {
            $vehicle->status = 'aktif';
        }

        $vehicle->save(); // Simpan perubahan kendaraan

        // Hapus log jika kendaraan sudah tidak membutuhkan perawatan (status = aktif)
        if ($vehicle->status == 'aktif') {
            MaintenanceNotification::where('vehicle_id', $vehicle->id)->delete();
        }

        return redirect('/dashboard')->with('success', 'Kendaraan berhasil diperbarui!');
    }



    public function destroy(Vehicle $vehicle) {
        $vehicle->delete();
        return redirect('/dashboard')->with('success', 'Kendaraan berhasil dihapus');
    }

    public function fuelEfficiency(Request $request) {
        $vehicles = Vehicle::all();
        $query = Vehicle::query();
        $notifications = Notification::all();
        // Filter berdasarkan nama kendaraan
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $vehicles = $query->paginate(10);
        return view('fuel_efficiency', compact('vehicles'));
    }

    public function updateFuelEfficiency(Request $request) {
        $request->validate([
            'vehicle_id' => 'required',
            'distance_traveled' => 'required|numeric',
            'fuel_used' => 'required|numeric',
        ]);

        $vehicle = Vehicle::find($request->vehicle_id);
        if ($vehicle) {
            $vehicle->distance_traveled = $request->distance_traveled;
            $vehicle->fuel_used = $request->fuel_used;

            // Hitung efisiensi bahan bakar
            $efficiency = $vehicle->fuel_used > 0 ? $vehicle->distance_traveled / $vehicle->fuel_used : 0;

            // Jika efisiensi < 5 km/l, ubah status menjadi "Rusak" dan tambahkan notifikasi
            if ($efficiency < 5) {
                $vehicle->status = 'rusak';

                // Simpan log / notifikasi perawatan
                MaintenanceNotification::create([
                    'vehicle_id' => $vehicle->id,
                    'message' => "Kendaraan {$vehicle->name} butuh perawatan karena efisiensi kendaraan sangat rendah atau di bawah target."
                ]);
            }else{
                $vehicle->status = 'aktif';
            }

            if ($vehicle->status == 'aktif') {
                MaintenanceNotification::where('vehicle_id', $vehicle->id)->delete();
            }
            $vehicle->save();
        }

        return redirect()->route('fuel.efficiency')->with('success', 'Data berhasil diperbarui.');
    }
}
