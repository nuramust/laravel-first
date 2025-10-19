<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dentistId = auth()->id();

        // Today's confirmed/completed appointments
        $today = Carbon::today()->format('Y-m-d');
        $todaysAppointments = Appointment::with(['patient', 'service'])
                                        ->where('dentist_id', $dentistId)
                                        ->where('appointment_date', $today)
                                        ->whereIn('status', ['confirmed', 'completed'])
                                        ->orderBy('start_time')
                                        ->get();

        // Upcoming appointments (next 7 days)
        $upcoming = Appointment::with(['patient', 'service'])
                              ->where('dentist_id', $dentistId)
                              ->whereBetween('appointment_date', [
                                  Carbon::tomorrow()->format('Y-m-d'),
                                  Carbon::now()->addDays(7)->format('Y-m-d')
                              ])
                              ->whereIn('status', ['confirmed', 'completed'])
                              ->orderBy('appointment_date')
                              ->orderBy('start_time')
                              ->get();

        return view('dentist.dashboard', compact('todaysAppointments', 'upcoming'));
    }

    public function completeAppointment(\Illuminate\Http\Request $request, $id)
    {
        $appointment = Appointment::where('dentist_id', auth()->id())
                                 ->where('id', $id)
                                 ->firstOrFail();

        $appointment->status = 'completed';
        $appointment->medical_notes = $request->medical_notes;
        $appointment->save();

        return back()->with('success', 'Appointment marked as completed.');
    }
}