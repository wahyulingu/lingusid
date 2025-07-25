<?php

namespace App\Actions\Term;

use App\Abstractions\Actions\Action;
use App\Models\Term;
use App\Repositories\TermRepository;
use InvalidArgumentException;

class CreateTermAction extends Action
{
    public function __construct(protected TermRepository $termRepository) {}

    protected function handler($term, array $validatedPayload = []): Term
    {
        if (is_string($term)) {
            return $this->termRepository->store(['text' => $term]);
        }

        throw new InvalidArgumentException('Term must be an string.');
    }
}
