<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // Relasi ke tabel kendaraan
            $table->date('scheduled_date'); // Tanggal perawatan
            $table->string('status')->default('scheduled'); // Status: scheduled, completed, cancelled
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('maintenance_schedules');
    }
};
