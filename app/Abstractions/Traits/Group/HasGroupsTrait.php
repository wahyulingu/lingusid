<?php

namespace App\Abstractions\Traits\Group;

use App\Models\Group;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasGroupsTrait
{
    /**
     * Get all of the groups for the model.
     */
    public function groups(): MorphToMany
    {
        return $this->morphToMany(Group::class, 'groupable', 'model_has_groups');
    }
}
