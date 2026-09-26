<?php

namespace App\Http\Resources;

use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'specializations' => $this->specializations,
            'bio' => $this->bio,
            'vizita_price' => $this->vizita_price,
            'profile_image' => $this->profile_image,
        ];
    }
}
