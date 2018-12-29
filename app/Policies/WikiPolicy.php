<?php

namespace App\Policies;

use App\User;
use App\Wiki;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class WikiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the wiki.
     *
     * @param  \App\User  $user
     * @param  \App\Wiki  $wiki
     * @return mixed
     */
    public function view(User $user, Wiki $wiki)
    {
        if($user->id == $wiki->user_id)
            return true;
        $privilege = 'showView';
        return UserRole::validateUser($user->id,$wiki->id,$privilege);
    }

    /**
     * Determine whether the user can create wikis.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the wiki.
     *
     * @param  \App\User  $user
     * @param  \App\Wiki  $wiki
     * @return mixed
     */
    public function update(User $user, Wiki $wiki)
    {
        //
    }
    public function pushUpdate(User $user, Wiki $wiki) {
        $privilege = 'pushUpdate';
        return UserRole::validateUser($user->id,$wiki->id,$privilege);
    }
    /**
     * Determine whether the user can delete the wiki.
     *
     * @param  \App\User  $user
     * @param  \App\Wiki  $wiki
     * @return mixed
     */
    public function delete(User $user, Wiki $wiki)
    {
        $privilege = 'pushDelete';
        return UserRole::validateUser($user->id,$wiki->id,$privilege);
    }
}
