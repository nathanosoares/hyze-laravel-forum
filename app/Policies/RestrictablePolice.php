<?php


namespace App\Policies;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Extensions\Permission\Group;

trait RestrictablePolice
{
    public function can(?User $user, string $rule, string $modelLabel, Model $model, bool $recursive, string $recursiveLabel = 'parent'): bool
    {
        if ($recursive) {
            for ($current = $model;; $current = $current->{$recursiveLabel}) {
                if ($current === null) {
                    break;
                }

                if (!isset(Group::getInstances()[$current->{"restrict_{$rule}"}])) {
                    return false;
                }

                $group = Group::getInstances()[$current->{"restrict_{$rule}"}];

                if (is_null($user)) {
                    return $group->is(Group::GUEST);
                }

                if (!$user->hasGroup($group)) {
                    return false;
                }
            }

            return true;
        }

        if (!isset(Group::getInstances()[$current->{"restrict_{$rule}"}])) {
            return false;
        }

        $group = Group::getInstances()[$current->{"restrict_{$rule}"}];

        if (is_null($user)) {
            return $group->is(Group::GUEST);
        }

        return $user->hasGroup($group);
    }
}
