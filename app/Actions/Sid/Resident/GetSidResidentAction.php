<?php

namespace App\Actions\Sid\Resident;

use App\Abstractions\Actions\Action;
use App\Models\Sid\SidResident;
use App\Repositories\Sid\SidResidentRepository;

class GetSidResidentAction extends Action
{
    public function __construct(protected SidResidentRepository $sidResidentRepository)
    {
    }

    protected function handler($payload = null, array $validatedPayload = []): ?SidResident
    {
        return $this->sidResidentRepository->find($payload->id);
    }
}
