<?php

namespace App\Repositories\Sid;

use App\Abstractions\Repository\ModelRepository;
use App\Models\Resident;
use App\Models\Sid\SidResident;
use App\Repositories\Repository;

/**
 * @extends Repository<Resident>
 */
class SidResidentRepository extends ModelRepository
{
    protected $model = SidResident::class;
}
