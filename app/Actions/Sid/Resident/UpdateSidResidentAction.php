<?php

namespace App\Actions\Sid\Resident;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidResident;
use App\Repositories\Sid\SidResidentRepository;
use Illuminate\Validation\Rule;

class UpdateSidResidentAction extends Action implements RuledActionContract
{
    public function __construct(protected SidResidentRepository $sidResidentRepository)
    {
    }

    public function rules(array $payload = []): array
    {
        return [
            'nik' => ['required', 'string', 'max:16', Rule::unique(SidResident::class)->ignore($payload['resident']->id)],
            'name' => ['required', 'string', 'max:255'],
            'no_kk' => ['nullable', 'string', 'max:16'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', Rule::in(['L', 'P'])],
            'religion' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function handler($payload = null, array $validatedPayload = []): bool
    {
        return $this->sidResidentRepository->update($payload['resident']->id, $validatedPayload);
    }
}
