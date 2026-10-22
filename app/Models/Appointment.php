<?php

namespace App\Models;

use App\Enum\AppointmentStatus;
use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['patient_id', 'doctor_id', 'booked_by_id', 'date', 'starts_at', 'status', 'total_cost', 'notes'])]
class Appointment extends Model
{
    /** @use HasFactory<AppointmentFactory> */
    use HasFactory, SoftDeletes;

    protected $with = ['patient.user:id,name', 'doctor.user:id,name', 'bookedBy:id,name'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'total_cost' => 'decimal:2',
            'status' => AppointmentStatus::class,
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(user::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(user::class, 'doctor_id');
    }

    public function bookedBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'booked_by_id');
    }

    public function followUp(): HasOne
    {
        return $this->hasOne(FollowUp::class);
    }
}
