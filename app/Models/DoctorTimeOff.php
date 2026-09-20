<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['doctor_id', 'date', 'start_time', 'end_time', 'reason'])]
class DoctorTimeOff extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorTimeOffFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'date' => 'date',
            'start_time' => 'time',
            'end_time' => 'time',
        ];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

}
