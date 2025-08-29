<?php

namespace App\Repositories;

use App\Abstractions\Repository\ModelRepository;
use App\Models\Metadata;

class MetadataRepository extends ModelRepository
{
    public function __construct(Metadata $model)
    {
        parent::__construct($model);
    }
}
