<?php

namespace App\Abstractions\Actions;

use App\Contracts\Action\RuledActionContract;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

abstract class Action
{
    private bool $ruleBypassed = false;

    /**
     * Handle the action's logic.
     *
     * @param  array  $validatedPayload  The validated data.
     * @param  mixed  $payload  The original payload.
     */
    abstract protected function handler($payload = null, array $validatedPayload = []): mixed;

    /**
     * Execute the action.
     *
     * @param  array  $payload  The data for the action.
     */
    public function handle(mixed $payload = null)
    {
        if (! $this->ruleBypassed && $this instanceof RuledActionContract) {
            if (is_array($payload)) {
                $validator = Validator::make($payload, $this->rules($payload));

                return $this->handler($payload, $validator->validate());

            }

            throw new InvalidArgumentException('Payload must be an array.');
        }

        return $this->handler($payload);
    }
}
