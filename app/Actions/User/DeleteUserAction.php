<?php

namespace App\Actions\User;

use App\Abstractions\Actions\Action;
use App\Repositories\UserRepository;

class DeleteUserAction extends Action
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->userRepository->delete($payload['user']->getKey());
    }
}
