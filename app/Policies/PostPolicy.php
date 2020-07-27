<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     * @throws \Exception
     */
    public function create(User $user)
    {
        $authors = \App\UserGroup::where('name', 'authors')->with(['users'])->get()->first();

        if (count((array) $authors) == 0)
            throw new \Exception('The authors group is missing');

        return $authors->users->contains($user);
    }

}
