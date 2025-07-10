<?php

namespace App\Repositories;

use App\Models\Penduduk;

/**
 * @extends Repository<Penduduk>
 */
class PendudukRepository extends Repository
{
    protected $model = Penduduk::class;
}
