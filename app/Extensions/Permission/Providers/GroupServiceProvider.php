<?php

namespace App\Extensions\Permission\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\Permission\GroupCache;
use App\Extensions\Permission\Group;

class GroupServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->singleton(GroupCache::class, function ($app) {
            return new GroupCache($app->make('cache'));
        });

        Group::macro('isHigher', function (?Group $group) {
            if (is_null($group)) {
                return true;
            }

            return $this->value['priority'] > $group->value['priority'];
        });

        Group::macro('isSameOrHigher', function (?Group $group) {
            if (is_null($group)) {
                return true;
            }

            return $this->value['priority'] >= $group->value['priority'];
        });

        Group::macro('sameOrLower', function () {
            $groups = collect(Group::getInstances())->filter(function ($item) {
                return $item->value['priority'] <= $this->value['priority'];
            })->flatten();

            return $groups;
        });
    }
}
