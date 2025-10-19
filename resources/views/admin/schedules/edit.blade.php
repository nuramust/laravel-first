@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Set Schedule for: {{ $dentist->name }}</h2>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">← Back to Schedules</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Weekly Availability</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.schedules.update', $dentist->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    @endphp

                    @foreach($days as $index => $dayName)
                        @php
                            $scheduleItem = $schedule->get($index);
                            $start = $scheduleItem ? $scheduleItem->start_time->format('H:i') : '';
                            $end = $scheduleItem ? $scheduleItem->end_time->format('H:i') : '';
                        @endphp

                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <strong>{{ $dayName }}</strong>
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="start_{{ $index }}" value="{{ old("start_{$index}", $start) }}">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="end_{{ $index }}" value="{{ old("end_{$index}", $end) }}">
                            </div>
                            <div class="col-md-1 text-center">
                                @if($start && $end)
                                    <span class="badge bg-success">Set</span>
                                @else
                                    <span class="badge bg-secondary">Closed</span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-info">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection