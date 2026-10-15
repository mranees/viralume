<?php

namespace App\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UseProfileImage
{
    public function addProfileImage(?UploadedFile $image)
    {
    if ($image) {
            $customImageName = time() . '_doctor_profile_image.'  . $image->getClientOriginalExtension();
            return $image->storeAs('doctors', $customImageName, 'public');
        }
        return 'doctor_default_profile_image.jpg';
    }
    public function editProfileImage(?UploadedFile $image)
    {
        //
    }
    public function removeProfileImage(string $path)
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
