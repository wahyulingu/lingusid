<?php

namespace App\Repositories;

use App\Models\User;

/**
 * @extends Repository<User>
 */
class UserRepository extends Repository
{
    protected $model = User::class;
}
