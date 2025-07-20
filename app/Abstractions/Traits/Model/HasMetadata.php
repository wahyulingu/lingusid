<?php

namespace App\Abstractions\Traits\Model;

use App\Models\Metadata;

trait HasMetadata
{
    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'entity');
    }
}
