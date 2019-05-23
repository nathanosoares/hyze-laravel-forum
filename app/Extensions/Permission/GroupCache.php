<?php

namespace App\Extensions\Permission;

use Illuminate\Cache\CacheManager;
use App\Models\Forums\Forum;

class GroupCache
{

    private $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    private function getKey(string $prefix, ?Group $group)
    {
        $key = 'GUEST';

        if (!is_null($group)) {
            $key = $group->key;
        }

        return "allowed_${prefix}_${key}";
    }

    public function getAllowedForumsToRead(?Group $group)
    {
        return $this->cacheManager->remember($this->getKey('forums', $group), 60, function () use ($group) {
            if (is_null($group)) {
                return Forum::where('restrict_read', null)->get();
            }

            return Forum::whereIn('restrict_read', $group->sameOrLower()->map(function ($item) {
                return $item->key;
            }))->orWhere('restrict_read', null)
                ->get();
        });
    }
}
