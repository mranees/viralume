<?php

namespace App\Services;

use App\Concerns\UseMetaPagination;
use App\Enum\UsersRoles;
use App\Http\Resources\FollowUpResource;
use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SpecializationService
{
    use UseMetaPagination;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /** @return array<string, mixed> */
    public function index(Request $request): array
    {
        $page = (int) request('page', 1);
        $key = "specializations:page:{$page}";
        if ($request->search != null) {
            $specializations = Specialization::search($request->search)->paginate(10);

            return [
                'data' => SpecializationResource::collection($specializations->items())->resolve(),
                'meta' => $this->getMetaPaginationData($specializations),
            ];
        } else {
            $specializations = Cache::remember($key, 5, function () {
                $paginated = Specialization::paginate(10);

                return [
                    'data' => SpecializationResource::collection($paginated->items())->resolve(),
                    'meta' => $this->getMetaPaginationData($paginated),
                ];
            });
        }

        return $specializations;
    }

    /** @param array<string, mixed> $data */
    public function store(array $data): void
    {
        DB::transaction(function () use ($data) {

            Specialization::create($data);

        });
    }

    /** @param array<string, mixed> $data */
    public function update(Specialization $specialization, array $data): void
    {
        DB::transaction(function () use ($specialization, $data) {

            $specialization->update($data);

        });
    }

    public function delete(Specialization $specialization): void
    {
        DB::transaction(fn () => $specialization->delete());
    }
}
