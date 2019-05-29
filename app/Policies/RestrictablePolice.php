<?php


namespace App\Policies;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Extensions\Permission\Group;

trait RestrictablePolice
{
    public function can(?User $user, string $rule, Model $model, bool $recursive = false, string $recursiveLabel = 'parent'): bool
    {
        if ($recursive) {
            for ($current = $model;; $current = $current->{$recursiveLabel}) {
                if ($current === null) {
                    break;
                }

                $rawGroup = $current->{"restrict_{$rule}"};

                if (is_null($rawGroup)) {
                    continue;
                }

                if (!isset(Group::getInstances()[$rawGroup])) {
                    return false;
                }

                $group = Group::getInstances()[$rawGroup];

                if (is_null($user) && !is_null($group)) {
                    return false;
                }

                if (!$user->hasGroup($group)) {
                    return false;
                }
            }

            return true;
        }

        $rawGroup = $model->{"restrict_{$rule}"};

        if (is_null($rawGroup)) {
            return true;
        }

        $group = Group::getInstances()[$rawGroup];

        if (is_null($user) && !is_null($group)) {
            return false;
        }

        return $user->hasGroup($group);
    }
}
