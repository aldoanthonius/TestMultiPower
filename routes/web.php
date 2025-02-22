<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MaintenanceNotification;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// login register, auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [VehicleController::class, 'index'])->name('dashboard');
    Route::resource('maintenance_schedules', MaintenanceScheduleController::class);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

//functional
Route::get('/dashboard/create', [VehicleController::class, 'create']);
Route::post('/dashboard/store', [VehicleController::class, 'store']);
Route::get('/dashboard/{vehicle}/edit', [VehicleController::class, 'edit']);
Route::post('/dashboard/{vehicle}/update', [VehicleController::class, 'update']);
Route::delete('/dashboard/{vehicle}/delete', [VehicleController::class, 'destroy']);
Route::get('/check-maintenance', [VehicleController::class, 'checkMaintenance']);
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/fuel-efficiency', [VehicleController::class, 'fuelEfficiency'])->name('fuel.efficiency');
Route::post('/fuel-efficiency/update', [VehicleController::class, 'updateFuelEfficiency'])->name('fuel.efficiency.update');
Route::resource('maintenance_schedules', MaintenanceScheduleController::class);
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
