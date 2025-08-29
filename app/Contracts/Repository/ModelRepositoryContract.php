<?php

namespace App\Contracts\Repository;

use Closure;
use Illuminate\Database\Eloquent\Model;

interface ModelRepositoryContract
{
    public static function resolve(string $modelName): RepositoryContract;

    public function getModel(?Closure $callable = null): Model;
}
