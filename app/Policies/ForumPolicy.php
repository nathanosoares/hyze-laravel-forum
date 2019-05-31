<?php

namespace App\Policies;

use App\Models\Forums\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class ForumPolicy
{
    use HandlesAuthorization, RestrictablePolice;

    public function read(?User $user, Forum $forum)
    {
        return $this->can($user, 'read', $forum->category, true)
            && $this->can($user, 'read', $forum, true);
    }

    public function write(User $user, Forum $forum)
    {
        return $user->hasVerifiedEmail()
            && $this->can($user, 'write', $forum->category, true)
            && $this->can($user, 'write', $forum, true);
    }
}
