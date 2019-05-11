<?php


namespace App\Policies;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

trait RestrictablePolice
{
    public function can(?User $user, string $rule, string $modelLabel, Model $model, bool $recursive, string $recursiveLabel = 'parent'): bool
    {
        if ($recursive) {
            for ($current = $model; ; $current = $current->{$recursiveLabel}) {
                if ($current === null) {
                    break;
                }

                if (!$current->{"restrict_{$rule}"}) {
                    continue;
                }

                if (is_null($user)) {
                    return false;
                }

                try {
                    if (!$user->hasPermissionTo("chatter {$rule} {$modelLabel} {$current->id}")) {
                        return false;
                    }
                } catch (PermissionDoesNotExist $exception) {
                    return false;
                }
            }

            return true;
        }

        if (!$model->{"restrict_{$rule}"}) {
            return true;
        }

        if (is_null($user)) {
            return false;
        }

        try {
            return $user->hasPermissionTo("chatter {$rule} {$modelLabel} {$model->id}");
        } catch (PermissionDoesNotExist $exception) {
            return false;
        }
    }
}