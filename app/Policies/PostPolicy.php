<?php

namespace App\Policies;

use App\Models\Forums\Post;
use App\Models\Forums\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Extensions\Permission\Group;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Thread $thread, Post $parent = null)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->hasGroup(Group::GAME_MASTER());
    }

    public function forceDelete(User $user, Post $post)
    {
        return $user->hasGroup(Group::GAME_MASTER());
    }
}
