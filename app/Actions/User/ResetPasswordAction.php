<?php

namespace App\Actions\User;

use App\Abstractions\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordAction extends Action
{
    protected function handler($payload, array $validatedPayload = []): mixed
    {
        $user = $payload['user'];
        $password = $payload['password'];

        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        return $user;
    }
}
