@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Receptionist Dashboard</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-warning text-dark">
        Today's Appointments ({{ \Carbon\Carbon::today()->format('M j, Y') }})
    </div>
    <div class="card-body">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Dentist</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Checked In</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td>{{ $appt->start_time->format('g:i A') }}</td>
                            <td>
                                <strong>{{ $appt->patient->name }}</strong><br>
                                <small>{{ $appt->patient->email }}</small>
                            </td>
                            <td>{{ $appt->dentist->name }}</td>
                            <td>{{ $appt->service->name }}</td>
                            <td>
                                @if($appt->status === 'confirmed')
                                    <span class="badge bg-warning text-dark">Confirmed</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                @if($appt->checked_in)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if(!$appt->checked_in)
                                    <form action="{{ route('receptionist.appointments.checkin', $appt->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Check In</button>
                                    </form>
                                @endif
                                <a href="{{ route('receptionist.appointments.print', $appt->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Print Slip</a>
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
@endsection