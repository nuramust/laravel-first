<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index()
    {
        $dentists = User::where('role', 'dentist')->get();
        $schedules = Schedule::with('dentist')->get()->groupBy('dentist_id');
        return view('admin.schedules.index', compact('dentists', 'schedules'));
    }

    /**
     * Show form to manage schedule for a specific dentist.
     */
    public function edit($dentistId)
    {
        $dentist = User::where('role', 'dentist')->findOrFail($dentistId);
        $schedule = Schedule::where('dentist_id', $dentist->id)->get()->keyBy('day_of_week');
        return view('admin.schedules.edit', compact('dentist', 'schedule'));
    }

    /**
     * Update the schedule for a dentist.
     */
    public function update(Request $request, $dentistId)
    {
        $dentist = User::where('role', 'dentist')->findOrFail($dentistId);

        // Days: 0=Sunday, 1=Monday, ..., 6=Saturday
        $days = [0, 1, 2, 3, 4, 5, 6];

        foreach ($days as $day) {
            $start = $request->input("start_{$day}");
            $end = $request->input("end_{$day}");

            if ($start && $end) {
                // Validate time format (HH:MM)
                if (strtotime($start) === false || strtotime($end) === false) {
                    return back()->withErrors(['Invalid time format for ' . $this->getDayName($day)]);
                }

                if (strtotime($start) >= strtotime($end)) {
                    return back()->withErrors(['End time must be after start time for ' . $this->getDayName($day)]);
                }

                Schedule::updateOrCreate(
                    ['dentist_id' => $dentist->id, 'day_of_week' => $day],
                    ['start_time' => $start, 'end_time' => $end]
                );
            } else {
                // Delete schedule if no times provided
                Schedule::where('dentist_id', $dentist->id)
                        ->where('day_of_week', $day)
                        ->delete();
            }
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    private function getDayName($dayIndex)
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return $days[$dayIndex] ?? 'Day';
    }
}