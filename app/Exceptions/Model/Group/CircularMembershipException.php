<?php

namespace App\Exceptions\Model\Group;

use App\Models\Group;
use Exception;

class CircularMembershipException extends Exception
{
    public function __construct(
        public readonly Group $source,
        public readonly Group $target
    ) {
        parent::__construct(
            __('messages.exceptions.models.group.circular_membership', [
                'target' => $target->id,
                'source' => $source->id,
            ])
        );
    }

    public function context(): array
    {
        return [
            'source_group_id' => $this->source->id,
            'target_group_id' => $this->target->id,
            'source_group_name' => $this->source->name,
            'target_group_name' => $this->target->name,
        ];
    }
}
