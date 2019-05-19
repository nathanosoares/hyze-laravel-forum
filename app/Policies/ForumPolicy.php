<?php

namespace App\Policies;

use App\Models\Chatter\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class ForumPolicy
{
    use HandlesAuthorization, RestrictablePolice;

    public function read(?User $user, Forum $forum)
    {
        return Gate::forUser($user)->allows('read', $forum->category)
            && $this->can($user, 'read', 'forum', $forum, true);
    }

    public function write(?User $user, Forum $forum)
    {
        return Gate::forUser($user)->allows('write', $forum->category)
            && $this->can($user, 'write', 'forum', $forum, true);
    }
}
