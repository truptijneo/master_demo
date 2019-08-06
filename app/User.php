<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable 
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table= 'users'; 

    protected $fillable = [
        'name', 'email', 'password', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function identities()
    {
        return $this->hasMany('App\SocialIdentity');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }

    public function billings()
    {
        return $this->hasMany('App\Billing');
    }
}
