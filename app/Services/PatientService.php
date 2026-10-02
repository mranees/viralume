<?php

namespace App\Services;

use App\Enum\UsersRoles;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PatientService
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
            $patients = Patient::search($request?->search)->paginate(10);

            return [
                'data' => json_decode(PatientResource::collection($patients->items())->toJson(), true),
                'meta' => [
                    'current_page' => $patients->currentPage(),
                    'from' => $patients->firstItem(),
                    'to' => $patients->lastItem(),
                    'last_page' => $patients->lastPage(),
                    'total' => $patients->total(),
                    'per_page' => $patients->perPage(),
                ],
            ];
        } else {
            $patients = Cache::remember($key, 5, function () {
                $paginated = Patient::paginate(10);

                return [
                    'data' => json_decode(PatientResource::collection($paginated->items())->toJson(), true),
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

        return $patients;
    }

    public function store (array $data):void
    {
        DB::transaction(function () use ($data) {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt('password'),
            'role' => UsersRoles::PATIENT,
        ]);

        Patient::create([
            'user_id' => $user->id,
            'address' => $data['address'],
        ]);

        });

    }

    public function update(Patient $patient, array $data)
    {
        DB::transaction(function () use ($patient,$data) {
        $patient->user()->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $patient->update([
            'address' => $data['address'],
        ]);

        });

    }

}
