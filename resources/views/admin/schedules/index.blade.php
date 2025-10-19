@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dentist Schedules</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-primary text-white">
        Manage Dentist Availability
    </div>
    <div class="card-body">
        @if($dentists->count() > 0)
            <div class="list-group">
                @foreach($dentists as $dentist)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $dentist->name }}</h5>
                        <small class="text-muted">{{ $dentist->email }}</small>
                    </div>
                    <a href="{{ route('admin.schedules.edit', $dentist->id) }}" class="btn btn-outline-primary btn-sm">Manage Schedule</a>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No dentists found. <a href="{{ route('admin.users.index') }}?role=dentist">Add a dentist</a>.</p>
        @endif
    </div>
</div>
@endsection