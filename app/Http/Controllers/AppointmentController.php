<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create()
    {
        $services = Service::all();
        $dentists = User::where('role', 'dentist')->get();
        return view('appointments.create', compact('services', 'dentists'));
    }

    /**
     * Get available time slots for a dentist on a given date.
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'dentist_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $service = Service::findOrFail($request->service_id);
        $dentist = User::where('role', 'dentist')->findOrFail($request->dentist_id);
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek; // 0=Sunday, 1=Monday, ...

        // Get dentist's schedule for this day
        $schedule = Schedule::where('dentist_id', $dentist->id)
                           ->where('day_of_week', $dayOfWeek)
                           ->first();

        if (!$schedule) {
            return response()->json(['slots' => []]);
        }

        // Parse start and end time
        $workStart = Carbon::parse($schedule->start_time);
        $workEnd = Carbon::parse($schedule->end_time);
        $duration = $service->duration; // in minutes

        // Get existing appointments for this dentist on this date
        $existingAppointments = Appointment::where('dentist_id', $dentist->id)
                                          ->where('appointment_date', $date->format('Y-m-d'))
                                          ->where('status', '!=', 'cancelled')
                                          ->get();

        $slots = [];
        $current = clone $workStart;

        while ($current->copy()->addMinutes($duration)->lte($workEnd)) {
            $slotStart = clone $current;
            $slotEnd = $current->copy()->addMinutes($duration);

            // Check for overlap with existing appointments
            $isAvailable = true;
            foreach ($existingAppointments as $appt) {
                $apptStart = Carbon::parse($appt->start_time);
                $apptEnd = Carbon::parse($appt->end_time);

                if ($slotStart->lt($apptEnd) && $slotEnd->gt($apptStart)) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                ];
            }

            $current->addMinutes(15); // 15-min buffer between slots
        }

        return response()->json(['slots' => $slots]);
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'dentist_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);
        $dentist = User::where('role', 'dentist')->findOrFail($request->dentist_id);

        // Final validation: ensure slot is still available
        $existing = Appointment::where('dentist_id', $dentist->id)
                              ->where('appointment_date', $request->appointment_date)
                              ->where('status', '!=', 'cancelled')
                              ->where(function ($query) use ($request) {
                                  $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                                        ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                                        ->orWhere(function ($q) use ($request) {
                                            $q->where('start_time', '<=', $request->start_time)
                                              ->where('end_time', '>=', $request->end_time);
                                        });
                              })->exists();

        if ($existing) {
            return back()->withErrors(['start_time' => 'This time slot is no longer available. Please choose another.']);
        }

        Appointment::create([
            'patient_id' => auth()->id(),
            'dentist_id' => $dentist->id,
            'service_id' => $service->id,
            'price' => $service->price,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Appointment booked successfully! Please wait for confirmation.');
    }
}