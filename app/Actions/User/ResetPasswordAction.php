<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordAction extends BaseAction
{
    protected function handler(array $validatedPayload, array $payload): mixed
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
