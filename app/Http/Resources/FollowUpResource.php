<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor' => $this->doctor->user->name,
            'date' => Carbon::parse($this->appointment->date)->format('Y-m-d'),
            'time' => Carbon::parse($this->appointment->starts_at)->format('H:i'),
            'notes' => $this->notes,
        ];
    }
}
