<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'service_id',
        'price', // ← added
        'checked_in',        // ← added
        'checked_in_at',     // ← added
        'medical_notes',
        'appointment_date',
        'start_time',
        'end_time',
        'notes',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'checked_in_at' => 'datetime',
        'checked_in' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}