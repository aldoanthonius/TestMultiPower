<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceNotification extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'message'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
