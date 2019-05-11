<?php

namespace App\Policies;

use App\Models\Chatter\Post;
use App\Models\Chatter\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Thread $thread, Post $parent = null)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->hasPermissionTo('chatter edit any post');
    }

    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->hasPermissionTo('chatter delete any post');
    }

    public function forceDelete(User $user, Post $post)
    {
        return $user->hasPermissionTo('chatter force delete any post');
    }
}
