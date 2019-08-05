<?php

namespace App\Policies;

use App\User;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function view(User $user)
    {
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;
        if($role == 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    { 
        $user = User::with('roles')->find(\Auth::id()); 
        $role = $user->roles[0]->name;

        if($role == 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function update(User $user)
    {
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;

        if($role == 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function delete(User $user)
    {
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;

        if($role == 'admin'){
            return true;
        }
        return false;
    }
}