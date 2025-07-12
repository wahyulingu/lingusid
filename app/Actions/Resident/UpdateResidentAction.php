<?php

namespace App\Actions\Resident;

use App\Actions\BaseAction;
use App\Models\Resident;
use App\Repositories\ResidentRepository;

class UpdateResidentAction extends BaseAction
{
    public function __construct(
        protected ResidentRepository $residentRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->residentRepository->update($payload['resident']->getKey(), $validatedPayload);
    }
}
