<?php

namespace App\Actions\Sid\Resident;

use App\Abstractions\Actions\Action;
use App\Repositories\Sid\SidResidentRepository;

class DeleteSidResidentAction extends Action
{
    public function __construct(protected SidResidentRepository $sidResidentRepository)
    {
    }

    protected function handler($payload = null, array $validatedPayload = []): bool
    {
        return $this->sidResidentRepository->delete($payload->id);
    }
}
