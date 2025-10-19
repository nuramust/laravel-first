@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Reports & Analytics</h2>
</div>

<!-- Date Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5>Total Appointments</h5>
                <h3>{{ $totalAppointments }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5>Total Revenue</h5>
                <h3>${{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Daily Appointments
            </div>
            <div class="card-body">
                <canvas id="dailyAppointmentsChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Revenue by Service
            </div>
            <div class="card-body">
                <canvas id="revenueByServiceChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                Dentist Workload
            </div>
            <div class="card-body">
                <canvas id="dentistWorkloadChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                New Patients (Weekly)
            </div>
            <div class="card-body">
                <canvas id="patientGrowthChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Tables (Optional) -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Revenue by Service (Detailed)
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByService as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>${{ number_format($service->revenue, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Daily Appointments Chart
const dailyCtx = document.getElementById('dailyAppointmentsChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'bar',
     {
        labels: @json(array_column($dailyAppointments, 'date')),
        datasets: [{
            label: 'Appointments',
             @json(array_column($dailyAppointments, 'count')),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// Revenue by Service
const revenueCtx = document.getElementById('revenueByServiceChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'pie',
    data: {
        labels: @json($revenueByService->pluck('name')),
        datasets: [{
            data: @json($revenueByService->pluck('revenue')),
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
            ]
        }]
    },
    options: { responsive: true }
});

// Dentist Workload
const dentistCtx = document.getElementById('dentistWorkloadChart').getContext('2d');
new Chart(dentistCtx, {
    type: 'bar',
     {
        labels: @json($dentistWorkload->pluck('name')),
        datasets: [{
            label: 'Appointments',
             @json($dentistWorkload->pluck('appointment_count')),
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Patient Growth
const patientCtx = document.getElementById('patientGrowthChart').getContext('2d');
new Chart(patientCtx, {
    type: 'line',
     {
        labels: @json(array_column($patientGrowth, 'week')),
        datasets: [{
            label: 'New Patients',
             @json(array_column($patientGrowth, 'count')),
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection