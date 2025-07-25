<?php

namespace App\Repositories;

use App\Models\Metadata;

class MetadataRepository extends Repository
{
    public function __construct(Metadata $model)
    {
        parent::__construct($model);
    }
}
