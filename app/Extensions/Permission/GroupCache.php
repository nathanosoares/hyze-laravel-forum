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
        return $this->cacheManager->remember($this->getKey('forums', $group), 1, function () use ($group) {

            $query = Forum::where('restrict_read', null);

            if (!is_null($group)) {
                $query = Forum::orWhereIn('restrict_read', $group->sameOrLower()->map(function ($item) {
                    return $item->key;
                }))->orWhere('restrict_read', null);
            }

            return $query->whereHas('category', function ($query) use ($group) {
                $query->where('restrict_read', null);

                if (!is_null($group)) {
                    $query->orWhereIn('restrict_read', $group->sameOrLower()->map(function ($item) {
                        return $item->key;
                    }));
                }
            })->get();
        });
    }
}
