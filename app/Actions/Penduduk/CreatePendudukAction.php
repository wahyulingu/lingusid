<?php

namespace App\Actions\Penduduk;

use App\Actions\BaseAction;
use App\Repositories\PendudukRepository;

class CreatePendudukAction extends BaseAction
{
    public function __construct(
        protected PendudukRepository $pendudukRepository
    ) {
    }

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->pendudukRepository->store($validatedPayload);
    }
}
