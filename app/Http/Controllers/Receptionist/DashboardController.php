<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        // Today's confirmed/completed appointments (not cancelled)
        $appointments = Appointment::with(['patient', 'dentist', 'service'])
                                  ->where('appointment_date', $today)
                                  ->whereIn('status', ['confirmed', 'completed'])
                                  ->orderBy('start_time')
                                  ->get();

        return view('receptionist.dashboard', compact('appointments'));
    }

    public function checkIn(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->checked_in = true;
        $appointment->checked_in_at = now();
        $appointment->save();

        return back()->with('success', 'Patient checked in successfully.');
    }

    public function printSlip($id)
    {
        $appointment = Appointment::with(['patient', 'dentist', 'service'])
                                 ->findOrFail($id);

        return view('receptionist.print-slip', compact('appointment'));
    }
}