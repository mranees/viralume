<?php

namespace App\Concerns;

trait UseMetaPagination
{

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
