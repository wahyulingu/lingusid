<?php

namespace App\Actions\Term;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Term;
use App\Repositories\TermRepository;
use Illuminate\Validation\Rule;

class UpdateTermAction extends Action implements RuledActionContract
{
    public function __construct(protected TermRepository $termRepository) {}

    protected function handler($payload, array $validatedPayload = []): Term
    {
        $termId = $validatedPayload['id'];
        unset($validatedPayload['id']);

        return $this->termRepository->update($termId, $validatedPayload);
    }

    public function rules(array $payload): array
    {
        return [
            'id' => ['required', 'exists:terms,id'],
            'text' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('terms', 'text')->ignore($payload['id'] ?? null),
            ],
        ];
    }
}
