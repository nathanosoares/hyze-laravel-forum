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
        return $user->id === $discussion->user_id || $user->hasPermissionTo('chatter edit any thread');
    }

    public function delete(User $user, Thread $discussion)
    {
        return $user->id === $discussion->user_id || $user->hasPermissionTo('chatter delete any thread');
    }

    public function forceDelete(User $user, Thread $discussion)
    {
        return $user->hasPermissionTo('chatter force delete any thread');
    }

    public function promote(User $user, Thread $discussion)
    {
        return $user->hasPermissionTo('chatter promote thread');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('chatter create thread');
    }
}
