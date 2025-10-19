@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Admin Dashboard</h2>
</div>

<div class="alert alert-success">
    Welcome, Admin! Manage your clinic efficiently.
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                User Management
            </div>
            <div class="card-body">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Manage Users & Roles</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Services
            </div>
            <div class="card-body">
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-success">Manage Dental Services</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                Dentist Schedules
            </div>
            <div class="card-body">
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-info">Manage Availability</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                Appointments
            </div>
            <div class="card-body">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-warning">Manage Appointments</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Reports & Analytics
            </div>
            <div class="card-body">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">View Reports</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Stats
            </div>
            <div class="card-body">
                <p>Total Appointments: <strong>24</strong></p>
                <p>Pending Confirmations: <strong>3</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection