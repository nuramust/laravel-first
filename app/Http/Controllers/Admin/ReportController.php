<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Date range (default: last 30 days)
        $startDate = $request->filled('start_date') ? $request->start_date : Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : Carbon::now()->format('Y-m-d');

        // Appointments in date range
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
                                  ->where('status', '!=', 'cancelled')
                                  ->get();

        // 1. Revenue by Service
        $revenueByService = Service::withCount(['appointments as revenue' => function ($query) use ($startDate, $endDate) {
            $query->select(\DB::raw('coalesce(sum(price), 0)'))
                  ->whereBetween('appointment_date', [$startDate, $endDate])
                  ->where('status', '!=', 'cancelled');
        }])->get();

        // 2. Appointments per Dentist
        $dentistWorkload = User::where('role', 'dentist')
                              ->withCount(['appointmentsAsDentist as appointment_count' => function ($query) use ($startDate, $endDate) {
                                  $query->whereBetween('appointment_date', [$startDate, $endDate])
                                        ->where('status', '!=', 'cancelled');
                              }])->get();

        // 3. Daily Appointments (for chart)
        $dailyAppointments = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($current->lte($end)) {
            $date = $current->format('Y-m-d');
            $count = $appointments->where('appointment_date', $date)->count();
            $dailyAppointments[] = [
                'date' => $current->format('M j'),
                'count' => $count
            ];
            $current->addDay();
        }

        // 4. Patient Growth (new patients per week)
        $patientGrowth = [];
        $startWeek = Carbon::parse($startDate)->startOfWeek();
        $endWeek = Carbon::parse($endDate)->endOfWeek();

        while ($startWeek->lte($endWeek)) {
            $weekEnd = clone $startWeek;
            $weekEnd->endOfWeek();
            $count = User::where('role', 'patient')
                        ->whereBetween('created_at', [$startWeek->format('Y-m-d'), $weekEnd->format('Y-m-d')])
                        ->count();
            $patientGrowth[] = [
                'week' => $startWeek->format('M j') . ' - ' . $weekEnd->format('M j'),
                'count' => $count
            ];
            $startWeek->addWeek();
        }

        // Total revenue
        $totalRevenue = $appointments->sum('price');
        $totalAppointments = $appointments->count();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'revenueByService',
            'dentistWorkload',
            'dailyAppointments',
            'patientGrowth',
            'totalRevenue',
            'totalAppointments'
        ));
    }
}