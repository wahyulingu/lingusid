<?php

namespace App\Repositories;

use App\Abstractions\Traits\Repository\HasModel;
use App\Contracts\Repository\ModelRepositoryContract;
use App\Contracts\Repository\RepositoryContract;

class GroupRepository implements ModelRepositoryContract, RepositoryContract
{
    use HasModel;
}
