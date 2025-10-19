<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Receptionist\DashboardController as ReceptionistDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Unified dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Patient booking
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/book-appointment', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/book-appointment', [PatientAppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/get-slots', [PatientAppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
});

// Receptionist routes
Route::middleware(['auth', 'role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
    Route::get('/dashboard', [ReceptionistDashboardController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/check-in', [ReceptionistDashboardController::class, 'checkIn'])->name('appointments.checkin');
    Route::get('/appointments/{id}/print', [ReceptionistDashboardController::class, 'printSlip'])->name('appointments.print');
});

// Admin panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class)->except(['create', 'store', 'destroy']);
    Route::resource('services', ServiceController::class);
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/{dentistId}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{dentistId}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/{id}/confirm', [AdminAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{id}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});