<?php

namespace App\Repositories;

use App\Models\Resident;

/**
 * @extends Repository<Resident>
 */
class ResidentRepository extends Repository
{
    protected $model = Resident::class;
}
