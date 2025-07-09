<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasSpecificationsContract
{
    public function specifications(): MorphMany;
}
