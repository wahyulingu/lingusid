<?php

namespace App\Actions;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class RuledAction extends BaseAction
{
    use Dispatchable;

    protected array $messages = [];

    protected array $attributes = [];

    /**
     * Validate the given arguments.
     *
     * @throws ValidationException
     */
    protected function validate(array $data): array
    {
        return Validator::make(
            $data,
            $this->rules($data),
            $this->messages(),
            $this->attributes()
        )->validate();
    }

    /**
     * Get the validation rules that apply to the action.
     */
    protected function rules(array $payload): array
    {
        return [];
    }

    /**
     * Get the validation messages that apply to the action.
     */
    protected function messages(): array
    {
        return $this->messages;
    }

    /**
     * Get the validation attributes that apply to the action.
     */
    protected function attributes(): array
    {
        return $this->attributes;
    }
}
