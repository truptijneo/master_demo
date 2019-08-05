<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
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
     * Determine whether the user can create orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
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
     * Determine whether the user can delete the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
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
