<?php

namespace App\Actions;

use App\Contracts\Action\RuledActionContract;
use Illuminate\Support\Facades\Validator;

abstract class Action
{
    /**
     * Handle the action's logic.
     *
     * @param  array  $validatedPayload  The validated data.
     * @param  array  $payload  The original payload.
     */
    abstract protected function handler(array $validatedPayload, array $payload): mixed;

    /**
     * Execute the action.
     *
     * @param  array  $payload  The data for the action.
     */
    final public function execute(array $payload = []): mixed
    {
        $validatedPayload = [];

        if ($this instanceof RuledActionContract) {
            $validatedPayload = Validator::make($payload, $this->rules($payload))->validate();
        }

        return $this->handler($validatedPayload, $payload);
    }

    /**
     * Statically handle the action.
     *
     * @param  array  $payload  The data for the action.
     * @param  callable|null  $before  A callback to execute before the action.
     */
    final public static function handle(array $payload = [], ?callable $before = null): mixed
    {
        /** @var static $action */
        $action = app(static::class);

        if (isset($before)) {
            $before($action);
        }

        return $action->execute($payload);
    }
}
