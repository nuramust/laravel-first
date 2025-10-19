<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_DENTIST = 'dentist';
    const ROLE_RECEPTIONIST = 'receptionist';
    const ROLE_PATIENT = 'patient';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDentist()
    {
        return $this->role === self::ROLE_DENTIST;
    }

    public function isReceptionist()
    {
        return $this->role === self::ROLE_RECEPTIONIST;
    }

    public function isPatient()
    {
        return $this->role === self::ROLE_PATIENT;
    }

    // Relationship: Dentist has many schedules
    public function schedules()
    {
        return $this->hasMany(\App\Models\Schedule::class, 'dentist_id');
    }

        // Patient has many appointments
    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    // Dentist has many appointments
    public function appointmentsAsDentist()
    {
        return $this->hasMany(Appointment::class, 'dentist_id');
    }
}