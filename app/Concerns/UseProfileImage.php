<?php

namespace App\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UseProfileImage
{
    public function addProfileImage(?UploadedFile $image): ?string
    {
        if ($image) {
            $customImageName = time().'_doctor_profile_image.'.$image->getClientOriginalExtension();

            return $image->storeAs('doctors', $customImageName, 'public') ?: throw new \RuntimeException('Failed to store profile image.');
        }

        return 'doctor_default_profile_image.jpg';
    }

    public function removeProfileImage(string $path): void
    {
        if ($path && $path != 'doctor_default_profile_image.jpg') {
            Storage::disk('public')->delete($path);
        }
    }
}
