<?php

namespace App\Actions\Resident;

use App\Abstractions\Actions\Action;
use App\Repositories\ResidentRepository;

class CreateResidentAction extends Action
{
    public function __construct(
        protected ResidentRepository $residentRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->residentRepository->store($validatedPayload);
    }
}
