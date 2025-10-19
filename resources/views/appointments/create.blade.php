@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Book an Appointment</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Appointment Details</h5>
            </div>
            <div class="card-body">
                <form id="bookingForm">
                    @csrf

                    <div class="mb-3">
                        <label for="service_id" class="form-label">Select Service *</label>
                        <select class="form-select" id="service_id" required>
                            <option value="">Choose a service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-duration="{{ $service->duration }}">
                                    {{ $service->name }} ({{ $service->duration }} min, ${{ number_format($service->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dentist_id" class="form-label">Select Dentist *</label>
                        <select class="form-select" id="dentist_id" required>
                            <option value="">Choose a dentist</option>
                            @foreach($dentists as $dentist)
                                <option value="{{ $dentist->id }}">{{ $dentist->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Select Date *</label>
                        <input type="date" class="form-control" id="date" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3" id="slotsContainer" style="display:none;">
                        <label class="form-label">Available Time Slots</label>
                        <div id="slotsList"></div>
                        <div id="noSlots" class="text-muted" style="display:none;">No available slots on this date.</div>
                    </div>

                    <div class="mb-3" id="notesContainer" style="display:none;">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" rows="3"></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="bookBtn" disabled>Book Appointment</button>
                    </div>
                </form>

                <form id="finalForm" method="POST" action="{{ route('appointments.store') }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="service_id" id="final_service_id">
                    <input type="hidden" name="dentist_id" id="final_dentist_id">
                    <input type="hidden" name="appointment_date" id="final_date">
                    <input type="hidden" name="start_time" id="final_start_time">
                    <input type="hidden" name="end_time" id="final_end_time">
                    <input type="hidden" name="notes" id="final_notes">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
});

document.getElementById('service_id').addEventListener('change', checkReady);
document.getElementById('dentist_id').addEventListener('change', checkReady);
document.getElementById('date').addEventListener('change', fetchSlots);

function checkReady() {
    const service = document.getElementById('service_id').value;
    const dentist = document.getElementById('dentist_id').value;
    const date = document.getElementById('date').value;
    if (service && dentist && date) {
        fetchSlots();
    }
}

function fetchSlots() {
    const serviceId = document.getElementById('service_id').value;
    const dentistId = document.getElementById('dentist_id').value;
    const date = document.getElementById('date').value;

    if (!serviceId || !dentistId || !date) return;

    fetch("{{ route('appointments.slots') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({
            service_id: serviceId,
            dentist_id: dentistId,
            date: date
        })
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('slotsContainer');
        const list = document.getElementById('slotsList');
        const noSlots = document.getElementById('noSlots');

        if (data.slots.length > 0) {
            list.innerHTML = '';
            data.slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-success me-2 mb-2';
                btn.textContent = slot.start + ' - ' + slot.end;
                btn.onclick = () => selectSlot(slot.start, slot.end);
                list.appendChild(btn);
            });
            noSlots.style.display = 'none';
            container.style.display = 'block';
        } else {
            list.innerHTML = '';
            noSlots.style.display = 'block';
            container.style.display = 'block';
        }
    });
}

function selectSlot(start, end) {
    document.querySelectorAll('#slotsList button').forEach(btn => {
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-success');
    });
    event.target.classList.remove('btn-outline-success');
    event.target.classList.add('btn-success');

    document.getElementById('final_start_time').value = start;
    document.getElementById('final_end_time').value = end;
    document.getElementById('notesContainer').style.display = 'block';
    document.getElementById('bookBtn').disabled = false;

    // Store other values
    document.getElementById('final_service_id').value = document.getElementById('service_id').value;
    document.getElementById('final_dentist_id').value = document.getElementById('dentist_id').value;
    document.getElementById('final_date').value = document.getElementById('date').value;
    document.getElementById('final_notes').value = document.getElementById('notes').value;
}

document.getElementById('bookBtn').addEventListener('click', function() {
    document.getElementById('finalForm').submit();
});

document.getElementById('notes').addEventListener('input', function() {
    document.getElementById('final_notes').value = this.value;
});
</script>
@endsection