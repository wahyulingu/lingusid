<?php

namespace App\Actions\User;

use App\Abstractions\Actions\Action;
use App\Repositories\UserRepository;

class CreateUserAction extends Action
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->userRepository->store($payload);
    }
}
