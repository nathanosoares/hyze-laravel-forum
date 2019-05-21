<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\Permission\Group;

class GroupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Group::macro('isHigher', function (?Group $group) {
            if (isnull($group)) {
                return true;
            }

            return $group != null && $this->value < $group->value;
        });

        Group::macro('isSameOrHigher', function (?Group $group) {
            if (isnull($group)) {
                return true;
            }

            return $group != null && $this->value <= $group->value;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { }
}
