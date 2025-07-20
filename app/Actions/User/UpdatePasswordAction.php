<?php

namespace App\Actions\User;

use App\Abstractions\Actions\Action;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction extends Action
{
    protected function handler($payload, array $validatedPayload = []): mixed
    {
        $user = $payload['user'];
        $password = $payload['password'];

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $user;
    }
}
