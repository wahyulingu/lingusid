<?php

namespace App\Actions\Resident;

use App\Abstractions\Actions\Action;
use App\Repositories\ResidentRepository;

class DeleteResidentAction extends Action
{
    public function __construct(
        protected ResidentRepository $residentRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->residentRepository->delete($payload['resident']->getKey());
    }
}
