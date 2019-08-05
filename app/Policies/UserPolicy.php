<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user)
    {
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;
        if($role=='admin')
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user)
    {
        $user = User::with('roles')->find(\Auth::id()); 
        $role = $user->roles[0]->name;
        if($role=='admin'){ 
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user)
    {
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;
        if($role == 'admin')
        {
            return true;
        }
        return false;
    }
}
