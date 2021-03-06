<?php

namespace App\Policies;

use App\User;
use App\Game;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the game.
     *
     * @param  \App\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function view(User $user, Game $game)
    {
        if($user->id == $game->user_id)
            return true;
        $privilege = 'showView';
        return UserRole::validateUser($user->id,$game->id,$privilege);
    }

    /**
     * Determine whether the user can create games.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the game.
     *
     * @param  \App\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function update(User $user, Game $game)
    {
        //
    }

    /**
     * Determine whether the user can delete the game.
     *
     * @param  \App\User  $user
     * @param  \App\Game  $game
     * @return mixed
     */
    public function delete(User $user, Game $game)
    {
        $privilege = 'pushDelete';
        return UserRole::validateUser($user->id,$game->id,$privilege);
    }
}
