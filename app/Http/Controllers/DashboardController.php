<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');

            case 'dentist':
                $dentistId = $user->id;
                $today = Carbon::today()->format('Y-m-d');
                $todaysAppointments = Appointment::with(['patient', 'service'])
                                                ->where('dentist_id', $dentistId)
                                                ->where('appointment_date', $today)
                                                ->whereIn('status', ['confirmed', 'completed'])
                                                ->orderBy('start_time')
                                                ->get();
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

            case 'receptionist':
                $today = Carbon::today()->format('Y-m-d');
                $appointments = Appointment::with(['patient', 'dentist', 'service'])
                                          ->where('appointment_date', $today)
                                          ->whereIn('status', ['confirmed', 'completed'])
                                          ->orderBy('start_time')
                                          ->get();
                return view('receptionist.dashboard', compact('appointments'));

            case 'patient':
            default:
                $upcoming = $user->appointmentsAsPatient()
                                ->where('appointment_date', '>=', now()->format('Y-m-d'))
                                ->where('status', '!=', 'cancelled')
                                ->orderBy('appointment_date')
                                ->orderBy('start_time')
                                ->get();
                return view('dashboard', compact('upcoming'));
        }
    }
}