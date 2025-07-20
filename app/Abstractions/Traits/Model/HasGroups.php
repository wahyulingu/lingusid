<?php

namespace App\Abstractions\Traits\Model;

use App\Models\Group;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasGroups
{
    /**
     * Get all of the groups for the model.
     */
    public function groups(): MorphToMany
    {
        return $this->morphToMany(Group::class, 'groupable', 'model_has_groups');
    }
}
