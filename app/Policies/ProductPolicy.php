<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Role;
use App\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
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
     * Determine whether the user can create products.
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
     * Determine whether the user can update the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
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
     * Determine whether the user can delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
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
