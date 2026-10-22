<?php

namespace App\Services;

use App\Concerns\UseMetaPagination;
use App\Enum\UsersRoles;
use App\Http\Resources\FollowUpResource;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PatientService
{
    use UseMetaPagination;

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
                'data' => PatientResource::collection($patients->items())->resolve(),
                'meta' => $this->getMetaPaginationData($patients),
            ];
        } else {
            $patients = Cache::remember($key, 5, function () {
                $paginated = Patient::paginate(10);

                return [
                    'data' => PatientResource::collection($paginated->items())->resolve(),
                    'meta' => $this->getMetaPaginationData($paginated),
                ];
            });
        }

        return $patients;
    }

    public function store(array $data): void
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

    public function show(Patient $patient): array
    {
        $patientData = new PatientResource($patient)->resolve();
        $paginated = $patient->followUps()->latest()->paginate(10);
        $patientFollowUps = [
            'data' => FollowUpResource::collection($paginated)->resolve(),
            'meta' => $this->getMetaPaginationData($paginated),
        ];

        // dd($patientData, $paginated, $patientFollowUps);
        return [
            'patient' => $patientData,
            'followUps' => $patientFollowUps,
        ];
    }

    public function update(Patient $patient, array $data)
    {
        DB::transaction(function () use ($patient, $data) {

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

    public function delete(Patient $patient)
    {
        DB::transaction(fn () => $patient->delete());
    }
}
