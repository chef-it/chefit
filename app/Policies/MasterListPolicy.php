<?php

namespace App\Policies;

use App\User;
use App\MasterList;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the masterList.
     *
     * @param  \App\User  $user
     * @param  \App\MasterList  $masterList
     * @return mixed
     */
    public function view(User $user, MasterList $masterList)
    {
        //
    }

    /**
     * Determine whether the user can create masterLists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the masterList.
     *
     * @param  \App\User  $user
     * @param  \App\MasterList  $masterList
     * @return mixed
     */
    public function update(User $user, MasterList $masterList)
    {
        return $user->id === $masterList->user_id;
    }

    /**
     * Determine whether the user can view edit page for the masterList.
     *
     * @param  \App\User  $user
     * @param  \App\MasterList  $masterList
     * @return mixed
     */
    public function edit(User $user, MasterList $masterList)
    {
        return $user->id === $masterList->user_id;
    }

    /**
     * Determine whether the user can delete the masterList.
     *
     * @param  \App\User  $user
     * @param  \App\MasterList  $masterList
     * @return mixed
     */
    public function delete(User $user, MasterList $masterList)
    {
        return $user->id === $masterList->user_id;
    }
}
