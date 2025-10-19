@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Welcome, {{ Auth::user()->name }}!</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Your Role
            </div>
            <div class="card-body">
                <strong>{{ ucfirst(Auth::user()->role ?? 'Patient') }}</strong>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Actions
            </div>
            <div class="card-body">
                @if(Auth::user()->isPatient())
                    <a href="{{ route('appointments.create') }}" class="btn btn-success">Book Appointment</a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                Upcoming Appointments
            </div>
            <div class="card-body">
                @php
                    $upcoming = Auth::user()->appointmentsAsPatient()
                                    ->where('appointment_date', '>=', now()->format('Y-m-d'))
                                    ->where('status', '!=', 'cancelled')
                                    ->orderBy('appointment_date')
                                    ->orderBy('start_time')
                                    ->get();
                @endphp

                @if($upcoming->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Dentist</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcoming as $appt)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M j, Y') }}</td>
                                    <td>{{ $appt->start_time->format('g:i A') }} - {{ $appt->end_time->format('g:i A') }}</td>
                                    <td>{{ $appt->dentist->name }}</td>
                                    <td>{{ $appt->service->name }}</td>
                                    <td>
                                        @if($appt->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($appt->status === 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($appt->status === 'completed')
                                            <span class="badge bg-secondary">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">You have no upcoming appointments.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection