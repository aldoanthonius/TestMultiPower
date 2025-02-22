<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\MaintenanceNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller{
    // agar method bisa dipakai oleh yang sudah login
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(){
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            if (!$vehicle->last_maintenance) {
                continue; 
            }

            $lastServiceDate = Carbon::parse($vehicle->last_maintenance);
            $daysSinceLastService = $lastServiceDate->diffInDays(Carbon::now());

            if ($daysSinceLastService > 30 && $vehicle->status != 'rusak') {
                $vehicle->status = 'rusak';
                $vehicle->save();

                $existingNotification = MaintenanceNotification::where('vehicle_id', $vehicle->id)
                    ->where('message', 'LIKE', "%lebih dari 30 hari tidak diservis%")
                    ->exists();

                if (!$existingNotification) {
                    MaintenanceNotification::create([
                        'vehicle_id' => $vehicle->id,
                        'message' => "Kendaraan {$vehicle->name} perlu perawatan! Sudah lebih dari 30 hari tidak diservis.",
                    ]);
                }
            }
        }

        $notifications = MaintenanceNotification::latest()->get();

        return view('notifications', compact('vehicles', 'notifications'));
    }

}
