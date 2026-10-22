<?php

namespace App\Services;

use App\Concerns\UseMetaPagination;
use App\Concerns\UseProfileImage;
use App\Enum\UsersRoles;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DoctorService
{
    use UseProfileImage, UseMetaPagination;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $page = (int) request('page', 1);
        $key = "doctors:page:{$page}";
        if ($request->search != null) {
            $doctors = Doctor::search($request?->search)->with('specializations')->paginate(10);

            return [
                'data' => DoctorResource::collection($doctors->items())->resolve(),
                'meta' => $this->getMetaPaginationData($doctors),
            ];
        } else {
            $doctors = Cache::tags('doctors.index')->remember($key, 5, function () {
                $paginated = Doctor::with('specializations')->paginate(10);

                return [
                    'data' => DoctorResource::collection($paginated->items())->resolve(),
                    'meta' => $this->getMetaPaginationData($paginated),
                ];
            });
        }

        return $doctors;
    }

    public function store (array $data):void
    {

        if(isset($data['profile_image'])) {
            $path = $this->addProfileImage($data['profile_image']);
        }else{
            $path = 'doctor_default_profile_image.jpg';
        }

        try {

        DB::transaction(function () use ($data, $path) {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt('password'),
            'role' => UsersRoles::DOCTOR,
        ]);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'bio' => $data['bio'],
            'vizita_price' => $data['vizita_price'],
            'profile_image' => $path,
            'is_active' => $data['is_active'],
        ]);

        $doctor->specializations()->sync($data['specializations']);
        });
        } catch (\Throwable $th) {
            $this->removeProfileImage($path);
            throw $th;
        }

    }

    public function update(Doctor $doctor, array $data)
    {

        $oldPath = $doctor->profile_image;
        $newPathCreated = false;
        if(isset($data['profile_image']))
        {
            if($data['profile_image']) {
                $path = $this->addProfileImage($data['profile_image']);
                $newPathCreated = true;
            }elseif($data['profile_image'] == null) {
                $path = null;
                $newPathCreated = true;
            }else{
                $path = $oldPath;
            }

        } else{
            $path = $oldPath;
        }

        try {

        DB::transaction(function () use ($doctor,$data,$path) {


        $doctor->user()->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $doctor->update([
            'bio' => $data['bio'],
            'profile_image' => $path,
            'vizita_price' => $data['vizita_price'],
            'is_active' => $data['is_active'],
        ]);

        $doctor->specializations()->sync($data['specializations']);

        });

        if($newPathCreated) {
            $this->removeProfileImage($oldPath);
        }

        } catch (\Throwable $th) {
            $this->removeProfileImage($path);
            throw $th;
        }
    }

    public function delete(Doctor $doctor)
    {
        if($doctor->profile_image) {
            Storage::disk('public')->delete($doctor->profile_image);
        }
        DB::transaction(fn() => $doctor->delete());
    }

}
