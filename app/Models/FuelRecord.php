<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    protected $fillable = ['vehicle_id', 'fuel_added', 'distance_traveled', 'date'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}

