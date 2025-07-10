<?php

namespace App\Actions\Penduduk;

use App\Actions\BaseAction;
use App\Models\Penduduk;
use App\Repositories\PendudukRepository;

class UpdatePendudukAction extends BaseAction
{
    public function __construct(
        protected PendudukRepository $pendudukRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->pendudukRepository->update($payload['penduduk']->getKey(), $validatedPayload);
    }
}
