<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'bio', 'vizita_price', 'profile_image'])]
#[Hidden(['is_active'])]
class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory;

    protected $with = ['user'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function timeOffs(): HasMany
    {
        return $this->hasMany(DoctorTimeOff::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    public function scopeSchedulesForDay(Doctor $doctor, Carbon $date) {
        return $doctor->schedules()->whereDate('date', $date)->get();
    }
    public function scopeAppointmentsForDay(Doctor $doctor, Carbon $date) {
        return $doctor->appointments()->whereDate('date', $date)->get();
    }
    public function scopeTimeOffsForDay(Doctor $doctor, Carbon $date) {
        return $doctor->timeOffs()->whereDate('date', $date)->get();
    }
}
