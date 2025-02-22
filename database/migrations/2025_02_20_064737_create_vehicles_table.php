<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration {
    public function up() {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->date('last_maintenance');
            $table->decimal('fuel_used', 8, 2)->nullable();
            $table->decimal('distance_traveled', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['fuel_used', 'distance_traveled']);
        });
    }
}
