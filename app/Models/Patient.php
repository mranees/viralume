<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

#[Fillable((['user_id', 'address']))]
class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    protected $with = ['user'];

    protected function casts(): array
    {
        return [
            'follow_up' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function ($patient){
            Cache::forget('patients');
        });
        static::deleted(function ($patient){
            Cache::forget('patients');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }
}
