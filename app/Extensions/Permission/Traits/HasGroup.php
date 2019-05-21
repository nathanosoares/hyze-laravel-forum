<?php

namespace App\Extensions\Permission\Traits;

use App\Extensions\Permission\Group;
use Illuminate\Support\Collection;
use Carbon\Carbon;

trait HasGroup
{
    public function hasStrictGroup(Group $group): bool
    {
        return $this->groups->contains('key', $group->key);
    }

    public function hasGroup(Group $group): bool
    {
        if ($this->getHighestGroup() == null) {
            return false;
        }

        return !$group->isHigher($this->getHighestGroup());
    }

    public function getHighestGroup()
    {
        return $this->groups->sortByDesc(function ($group) {
            return $group->priority;
        })->first();
    }

    public function getHighestGroupAttribute()
    {
        return $this->getHighestGroup();
    }

    public function getGroupsAttribute(): Collection
    {
        if (isset($this->attributes['groups'])) {
            return $this->attributes['groups'];
        }

        $result = $this->getConnection()->table('user_groups')
            ->leftJoin('servers', function ($join) {
                $join->on('servers.id', 'user_groups.server_id');
            })
            ->leftJoin('user_groups_due', function ($join) {
                $join->on('user_groups_due.user_id', 'user_groups.user_id')
                    ->on('user_groups_due.group_id', 'user_groups.group_id')
                    ->on('user_groups_due.server_id', 'user_groups.server_id');
            })
            ->where('user_groups.user_id', $this->id)
            ->selectRaw('user_groups.group_id, servers.display_name as "server", user_groups_due.due_at')
            ->get();


        $groups = $result->map(function ($item) {
            if (isset(Group::getInstances()[$item->group_id])) {
                $rawGroup = Group::getInstances()[$item->group_id];


                $group = (object)[
                    'name' => $rawGroup->key,
                    'display_name' => $rawGroup->value['display_name'],
                    'priority' => $rawGroup->value['priority'],
                    'server' => $item->server,
                    'due_at' => null
                ];

                if ($item->due_at) {
                    $group->due_at = new Carbon($item->due_at);
                }

                return  $group;
            }

            return null;
        })->filter();

        $this->attributes['groups'] = $groups;

        return $this->attributes['groups'];
    }
}
