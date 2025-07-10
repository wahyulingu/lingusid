<?php

namespace App\Actions\Penduduk;

use App\Actions\BaseAction;
use App\Models\Penduduk;
use App\Repositories\PendudukRepository;

class DeletePendudukAction extends BaseAction
{
    public function __construct(
        protected PendudukRepository $pendudukRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->pendudukRepository->delete($payload['penduduk']->getKey());
    }
}
