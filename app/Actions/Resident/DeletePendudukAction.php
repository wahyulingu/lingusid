<?php

namespace App\Actions\Resident;

use App\Actions\BaseAction;
use App\Models\Resident;
use App\Repositories\ResidentRepository;

class DeleteResidentAction extends BaseAction
{
    public function __construct(
        protected ResidentRepository $residentRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->residentRepository->delete($payload['resident']->getKey());
    }
}
