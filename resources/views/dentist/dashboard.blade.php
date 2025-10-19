@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dentist Dashboard</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Today's Appointments -->
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        Today's Appointments ({{ \Carbon\Carbon::today()->format('M j, Y') }})
    </div>
    <div class="card-body">
        @if($todaysAppointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Medical Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todaysAppointments as $appt)
                        <tr>
                            <td>{{ $appt->start_time->format('g:i A') }} - {{ $appt->end_time->format('g:i A') }}</td>
                            <td>{{ $appt->patient->name }}</td>
                            <td>{{ $appt->service->name }}</td>
                            <td>
                                @if($appt->status === 'confirmed')
                                    <span class="badge bg-warning text-dark">Confirmed</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                @if($appt->medical_notes)
                                    <small>{{ Str::limit($appt->medical_notes, 50) }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No appointments scheduled for today.</p>
        @endif
    </div>
</div>

<!-- Upcoming Appointments -->
<div class="card">
    <div class="card-header bg-info text-white">
        Upcoming Appointments (Next 7 Days)
    </div>
    <div class="card-body">
        @if($upcoming->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Service</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcoming as $appt)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M j') }}</td>
                            <td>{{ $appt->start_time->format('g:i A') }}</td>
                            <td>{{ $appt->patient->name }}</td>
                            <td>{{ $appt->service->name }}</td>
                            <td>
                                @if($appt->status === 'confirmed')
                                    <span class="badge bg-warning text-dark">Confirmed</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No upcoming appointments.</p>
        @endif
    </div>
</div>
@endsection