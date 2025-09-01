<?php

namespace App\Actions\Sid\Resident;

use App\Abstractions\Actions\Action;
use App\Repositories\Sid\SidResidentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GetSidResidentsAction extends Action
{
    public function __construct(protected SidResidentRepository $sidResidentRepository)
    {
    }

    protected function handler($payload = null, array $validatedPayload = []): LengthAwarePaginator
    {
        return $this->sidResidentRepository->paginate();
    }
}
