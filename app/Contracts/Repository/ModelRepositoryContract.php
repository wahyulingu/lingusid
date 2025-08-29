<?php

namespace App\Contracts\Repository;

interface ModelRepositoryContract
{
    public static function resolve(string $modelName): RepositoryContract;
}
