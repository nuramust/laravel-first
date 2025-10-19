@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Receptionist Dashboard</h2>
</div>

<div class="alert alert-warning">
    Welcome! Check in patients and manage walk-ins.
</div>

<div class="card">
    <div class="card-header bg-warning text-dark">
        Actions
    </div>
    <div class="card-body">
        <a href="#" class="btn btn-warning mb-2">Check In Patient</a><br>
        <a href="#" class="btn btn-warning">Create Walk-in Appointment</a>
    </div>
</div>
@endsection