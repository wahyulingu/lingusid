<?php

namespace App\Actions\Group;

use App\Exceptions\Model\Group\CircularMembershipException;
use App\Models\Group;

class AddGroupChildAction
{
    protected const int CircularMembershipCheckerDeep = 10;

    public function execute(Group $group, Group $child): void
    {
        if ($this->isCircular($group, $child)) {
            throw new CircularMembershipException($group, $child);
        }

        $group->children()->attach($child);
    }

    protected function isCircular(Group $source, Group $target, int $depth = 0): bool
    {
        if ($depth > static::CircularMembershipCheckerDeep) {
            return false;
        }

        foreach ($target->children as $child) {
            if ($child->id === $source->id) {
                return true;
            }

            return $this->isCircular($source, $child, ++$depth);
        }

        return false;
    }
}
