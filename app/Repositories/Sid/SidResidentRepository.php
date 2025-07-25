<?php

namespace App\Repositories\Sid;

use App\Models\Resident;
use App\Models\Sid\SidResident;
use App\Repositories\Repository;

/**
 * @extends Repository<Resident>
 */
class SidResidentRepository extends Repository
{
    protected $model = SidResident::class;
}
