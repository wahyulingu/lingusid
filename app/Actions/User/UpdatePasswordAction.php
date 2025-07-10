<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction extends BaseAction
{
    protected function handler(array $validatedPayload, array $payload): mixed
    {
        $user = $payload['user'];
        $password = $payload['password'];

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $user;
    }
}
