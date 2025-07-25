<?php

namespace App\Actions\Sid\Resident;

use App\Abstractions\Actions\Action;
use App\Repositories\Sid\SidResidentRepository;

class UpdateResidentAction extends Action
{
    public function __construct(
        protected SidResidentRepository $residentRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->residentRepository->update($payload['resident']->getKey(), $validatedPayload);
    }
}
