<?php

namespace App\Actions\User;

use App\Actions\BaseAction;

class UpdateUserAction extends BaseAction
{
    protected function handler(array $validatedPayload, array $payload): mixed
    {
        $user = $payload['user'];

        $user->fill($validatedPayload);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }
}
