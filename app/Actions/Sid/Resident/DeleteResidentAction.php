<?php

namespace App\Actions\Sid\Resident;

use App\Abstractions\Actions\Action;
use App\Repositories\Sid\SidResidentRepository;

class DeleteResidentAction extends Action
{
    public function __construct(
        protected SidResidentRepository $residentRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->residentRepository->delete($payload['resident']->getKey());
    }
}
