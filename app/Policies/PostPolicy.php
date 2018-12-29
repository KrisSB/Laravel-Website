<?php

namespace App\Policies;

use App\User;
use App\WikiPost;
use App\UserRole;
use App\RevisionPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the wiki post.
     *
     * @param  \App\User  $user
     * @param  \App\WikiPost  $wikiPost
     * @return mixed
     */
    public function view(User $user, WikiPost $wikiPost)
    {
        if($user->id == $wikiPost->user_id)
            return true;
        $privilege = 'showView';
        return UserRole::validateUser($user->id,$wikiPost->wiki_id,$privilege);
    }

    /**
     * Determine whether the user can create wiki posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the wiki post.
     *
     * @param  \App\User  $user
     * @param  \App\WikiPost  $wikiPost
     * @return mixed
     */
    public function update(User $user, RevisionPost $revisionPost, WikiPost $wikiPost)
    {
        if($user->id == $revisionPost->user_id)
            return true;
        $privilege = 'showEdit';
        return UserRole::validateUser($user->id,$wikiPost->wiki_id,$privilege);
    }
    public function pushUpdate(User $user, WikiPost $wikiPost) {
        $privilege = 'pushUpdate';
        return UserRole::validateUser($user->id,$wikiPost->wiki_id,$privilege);
    }
    /**
     * Determine whether the user can delete the wiki post.
     *
     * @param  \App\User  $user
     * @param  \App\WikiPost  $wikiPost
     * @return mixed
     */
    public function delete(User $user, WikiPost $wikiPost)
    {
        $privilege = 'pushDelete';
        return UserRole::validateUser($user->id,$wikiPost->wiki_id,$privilege);
    }
}
