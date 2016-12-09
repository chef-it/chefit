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
    public function masterlist(User $user, MasterList $masterList)
    {
        return $user->id === $masterList->user_id;
    }
    
}
