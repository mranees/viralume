<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\DoctorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

#[Fillable(['user_id', 'bio', 'vizita_price', 'profile_image', 'is_active'])]
class Doctor extends Model
{
    /** @use HasFactory<DoctorFactory> */
    use HasFactory;

    protected $with = ['user:id,name,email,phone'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function ($patient) {
            Cache::tags('doctors.index')->flush();
        });
        static::deleted(function ($patient) {
            Cache::tags('doctors.index')->flush();
        });
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsToMany<Specialization, $this> */
    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class);
    }

    /** @return HasMany<DoctorSchedule, $this> */
    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    /** @return HasMany<DoctorTimeOff, $this> */
    public function timeOffs(): HasMany
    {
        return $this->hasMany(DoctorTimeOff::class);
    }

    /** @return HasMany<Appointment, $this> */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return HasMany<FollowUp, $this> */
    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    /**
     * @param  Builder<Doctor>  $query
     * @return Builder<Doctor>
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, fn ($query, $search) => $query->whereHas('user', fn ($q) => $q->where('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('phone', 'like', '%'.$search.'%')));
    }

    /**
     * @param  Builder<Doctor>  $query
     * @return Builder<Doctor>
     */
    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return Collection<int, DoctorSchedule>
     */
    public function schedulesForDay(Carbon $date): Collection
    {
        return $this->schedules()->whereDate('date', $date)->get();
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function appointmentsForDay(Carbon $date): Collection
    {
        return $this->appointments()->whereDate('date', $date)->get();
    }

    /**
     * @return Collection<int, DoctorTimeOff>
     */
    public function timeOffsForDay(Carbon $date): Collection
    {
        return $this->timeOffs()->whereDate('date', $date)->get();
    }
}
