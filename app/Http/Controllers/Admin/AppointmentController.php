<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'dentist', 'service'])
                           ->orderBy('appointment_date', 'desc')
                           ->orderBy('start_time', 'desc');

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('appointment_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('appointment_date', '<=', $request->end_date);
        }

        $appointments = $query->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Confirm an appointment.
     */
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        return back()->with('success', 'Appointment confirmed.');
    }

    /**
     * Cancel an appointment.
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();

        return back()->with('success', 'Appointment cancelled.');
    }
}