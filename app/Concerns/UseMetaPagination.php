<?php

namespace App\Concerns;

use Illuminate\Pagination\LengthAwarePaginator;

trait UseMetaPagination
{
    /**
     * @param  LengthAwarePaginator<int, mixed>  $paginated
     * @return array<string, mixed>
     */
    public function getMetaPaginationData($paginated): array
    {
        return [
            'current_page' => $paginated->currentPage(),
            'from' => $paginated->firstItem(),
            'to' => $paginated->lastItem(),
            'last_page' => $paginated->lastPage(),
            'total' => $paginated->total(),
            'per_page' => $paginated->perPage(),
        ];
    }
}
