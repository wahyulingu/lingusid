<?php

namespace App\Actions\Resident;

use App\Actions\BaseAction;
use App\Repositories\ResidentRepository;

class CreateResidentAction extends BaseAction
{
    public function __construct(
        protected ResidentRepository $residentRepository
    ) {
    }

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->residentRepository->store($validatedPayload);
    }
}
