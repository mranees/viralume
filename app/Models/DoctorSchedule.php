<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['doctor_id', 'day_of_week', 'starts_at', 'ends_at', 'is_active'])]
class DoctorSchedule extends Model
{
    use HasFactory;

    protected $with = ['doctor'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'starts_at' => 'time',
            'ends_at' => 'time',
        ];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }


}
