<?php

namespace App\Actions\Term;

use App\Abstractions\Actions\Action;
use App\Repositories\TermRepository;

class DeleteTermAction extends Action
{
    public function __construct(protected TermRepository $termRepository) {}

    protected function handler($payload, array $validatedPayload = []): bool
    {
        return $this->termRepository->delete($payload['term']->id);
    }
}
