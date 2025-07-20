<?php

namespace App\Exceptions\Model\Group;

use Exception;

class SystemGroupImmutableException extends Exception
{
    public function __construct(protected readonly string $slug)
    {
        parent::__construct("System-defined groups [{$slug}] are read-only and cannot be updated or deleted.");
    }

    public function context(): array
    {
        return ['slug' => $this->slug];
    }
}
