<?php

namespace App\Policies;

use App\Models\Chatter\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Thread $discussion)
    {
        return $user->id === $discussion->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function delete(User $user, Thread $discussion)
    {
        return $user->id === $discussion->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function forceDelete(User $user, Thread $discussion)
    {
        $user->hasGroup(Group::GAME_MASTER());
    }

    public function promote(User $user, Thread $discussion)
    {
        $user->hasGroup(Group::GAME_MASTER());
    }

    public function create(User $user)
    {
        $user->hasGroup(Group::GAME_MASTER());
    }
}
