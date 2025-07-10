<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Repositories\UserRepository;

class CreateUserAction extends BaseAction
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->userRepository->store($payload);
    }
}
