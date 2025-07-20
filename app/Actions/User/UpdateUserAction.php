<?php

namespace App\Actions\User;

use App\Abstractions\Actions\Action;

class UpdateUserAction extends Action
{
    protected function handler($payload, array $validatedPayload = []): mixed
    {
        $user = $payload['user'];

        $user->fill($payload);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }
}
