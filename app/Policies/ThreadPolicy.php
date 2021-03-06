<?php

namespace App\Policies;

use App\Models\Forums\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Extensions\Permission\Group;

class ThreadPolicy
{
    use HandlesAuthorization, RestrictablePolice;

    public function update(User $user, Thread $thread)
    {
        return $user->id === $thread->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function rename(User $user, Thread $thread)
    {
        return $thread->user_id === $user->id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function destroy(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function forceDelete(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function sticky(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function promote(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function close(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::MANAGER());
    }

    public function reply(User $user, Thread $thread)
    {
        if (!$user->hasVerifiedEmail() || $thread->trashed() || ($thread->closed && !$user->hasGroup(Group::MANAGER()))) {
            return false;
        }

        if ($user->id == $thread->user_id) {
            return true;
        }

        return $this->can($user, 'write', $thread);
    }

    public function read(?User $user, Thread $thread)
    {
        if ($user && $user->id == $thread->user_id) {
            return true;
        }

        return $this->can($user, 'read', $thread->forum->category, true)
            && $this->can($user, 'read', $thread->forum, true)
            && $this->can($user, 'read', $thread);
    }
}
