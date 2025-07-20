<?php

namespace App\Actions\Metadata;

use App\Abstractions\Actions\RuledAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Metadata;
use App\Repositories\MetadataRepository;
use Illuminate\Validation\Rule;

class CreateMetadataAction extends RuledAction implements RuledActionContract
{
    public function __construct(protected readonly MetadataRepository $metadataRepository)
    {
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'integer', Rule::exists('groups', 'id')],
            'value' => ['required', 'string', 'max:255'],
            'extra' => ['nullable', 'json'],
        ];
    }

    protected function handler(array $validatedPayload, array $payload): Metadata
    {
        return $this->metadataRepository->create($validatedPayload);
    }
}
