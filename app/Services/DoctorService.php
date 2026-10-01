<?php

namespace App\Services;

use App\Enum\UsersRoles;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DoctorService
{
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
                'data' => json_decode(DoctorResource::collection($doctors->items())->toJson(), true),
                'meta' => [
                    'current_page' => $doctors->currentPage(),
                    'from' => $doctors->firstItem(),
                    'to' => $doctors->lastItem(),
                    'last_page' => $doctors->lastPage(),
                    'total' => $doctors->total(),
                    'per_page' => $doctors->perPage(),
                ],
            ];
        } else {
            $doctors = Cache::remember($key, 5, function () {
                $paginated = Doctor::with('specializations')->paginate(10);

                return [
                    'data' => json_decode(DoctorResource::collection($paginated->items())->toJson(), true),
                    'meta' => [
                        'current_page' => $paginated->currentPage(),
                        'from' => $paginated->firstItem(),
                        'to' => $paginated->lastItem(),
                        'last_page' => $paginated->lastPage(),
                        'total' => $paginated->total(),
                        'per_page' => $paginated->perPage(),
                    ],
                ];
            });
        }



        return $doctors;
    }

    public function store (array $data):void
    {
        DB::transaction(function () use ($data) {

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
            'profile_image' => $data['profile_image'],
            'is_active' => $data['is_active'],
        ]);

        $doctor->specializations()->sync($data['specializations']);
        });

    }

    public function update(Doctor $doctor, array $data)
    {
        DB::transaction(function () use ($doctor,$data) {
        $doctor->user()->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $doctor->update([
            'bio' => $data['bio'],
            'vizita_price' => $data['vizita_price'],
            'profile_image' => $data['profile_image'],
            'is_active' => $data['is_active'],
        ]);

        $doctor->specializations()->sync($data['specializations']);
        });

    }

}
