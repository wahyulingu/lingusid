<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Models\User;
use App\Repositories\UserRepository;

class DeleteUserAction extends BaseAction
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->userRepository->delete($payload['user']->getKey());
    }
}
