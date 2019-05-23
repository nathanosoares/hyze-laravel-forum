<?php

namespace App\Policies;

use App\Models\Forums\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization, RestrictablePolice;

    public function update(User $user, Thread $thread)
    {
        return $user->id === $thread->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function delete(User $user, Thread $thread)
    {
        return $user->id === $thread->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function forceDelete(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function rename(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER()) || $thread->user_id === $user->id;
    }

    public function sticky(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function promote(User $user, Thread $thread)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function create(User $user)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }

    public function read(?User $user, Thread $thread)
    {
        return $this->can($user, 'read', $thread->forum, true) && $this->can($user, 'read', $thread);
    }
}
