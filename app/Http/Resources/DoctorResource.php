<?php

namespace App\Http\Resources;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Doctor */
class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;

    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenLoaded('user', fn () => $this->user->name),
            'email' => $this->whenLoaded('user', fn () => $this->user->email),
            'phone' => $this->whenLoaded('user', fn () => $this->user->phone),
            'specializations' => $this->whenLoaded('specializations') ?
            SpecializationResource::collection($this->specializations)->resolve() : [],
            'bio' => $this->bio,
            'vizita_price' => $this->vizita_price,
            'profile_image' => $this->profile_image ? Storage::disk('public')->url($this->profile_image) : null,
            'is_active' => $this->is_active,
        ];
    }
}
