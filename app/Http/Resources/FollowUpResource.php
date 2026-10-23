<?php

namespace App\Http\Resources;

use App\Models\FollowUp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FollowUp */
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
            'doctor' => $this->whenLoaded('doctor', fn () => $this->doctor?->user?->name),
            'date' => $this->whenLoaded('appointment', fn () => $this->appointment?->date),
            'time' => $this->whenLoaded('appointment', fn () => $this->appointment->starts_at ? Carbon::parse($this->appointment->starts_at)->format('H:i') : null),
            'notes' => $this->notes,
        ];
    }
}
