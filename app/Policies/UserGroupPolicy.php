<?php

namespace App\Policies;

use App\User;
use App\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Validate that the user can create a user group
     *
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        $admins = UserGroup::where('name', 'admin')->with([User::class])->get()->first();

        if (count((array) $admins) == 0)
            throw new \Exception('The admin group is not created');

        return $admins->users->contains($user);
    }

}
