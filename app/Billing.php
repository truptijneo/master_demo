<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table = 'billing';
    protected $fillable = ['name', 'email', 'mobile', 'address', 'city', 'pincode', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'id', 'billing_id');
    }
}
