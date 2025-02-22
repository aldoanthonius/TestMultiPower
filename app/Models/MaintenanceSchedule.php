<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'scheduled_date', 'status'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
