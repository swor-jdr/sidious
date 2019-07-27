<?php
namespace Modules\Factions\Traits;

use Modules\Factions\Models\Group;

trait InGroups
{
    /**
     * Get object groups
     *
     * @return mixed
     */
    public function groups()
    {
        return $this->morphMany(Group::class, 'element', 'group_elements')
            ->withPivot("isLeader", "isMain", "active");
    }
}