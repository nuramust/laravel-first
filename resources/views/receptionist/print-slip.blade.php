<!DOCTYPE html>
<html>
<head>
    <title>Appointment Slip - NuraDental</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
        .value { display: inline-block; }
        .footer { margin-top: 30px; text-align: center; font-size: 0.9em; color: #666; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>NuraDental Clinic</h2>
        <p>Appointment Confirmation Slip</p>
    </div>

    <div class="info">
        <div><span class="label">Patient:</span> <span class="value">{{ $appointment->patient->name }}</span></div>
        <div><span class="label">Email:</span> <span class="value">{{ $appointment->patient->email }}</span></div>
    </div>

    <div class="info">
        <div><span class="label">Date:</span> <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</span></div>
        <div><span class="label">Time:</span> <span class="value">{{ $appointment->start_time->format('g:i A') }} - {{ $appointment->end_time->format('g:i A') }}</span></div>
        <div><span class="label">Dentist:</span> <span class="value">{{ $appointment->dentist->name }}</span></div>
        <div><span class="label">Service:</span> <span class="value">{{ $appointment->service->name }}</span></div>
    </div>

    <div class="info">
        <div><span class="label">Status:</span> 
            <span class="value">
                @if($appointment->status === 'confirmed') Confirmed
                @elseif($appointment->status === 'completed') Completed
                @endif
            </span>
        </div>
        <div><span class="label">Checked In:</span> 
            <span class="value">{{ $appointment->checked_in ? 'Yes (' . $appointment->checked_in_at->format('g:i A') . ')' : 'No' }}</span>
        </div>
    </div>

    <div class="footer no-print">
        <p>Click <button onclick="window.print()">Print</button> to print this slip.</p>
    </div>

    <script>
        // Auto-print in 2 seconds when opened in new tab
        setTimeout(function() {
            if (window.location.search.indexOf('print') === -1) {
                window.print();
            }
        }, 2000);
    </script>
</body>
</html>