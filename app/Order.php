<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table='orders';
    protected $dates = ['deleted_at'];
    protected $fillable = ['order_no', 'order_date', 'order_total', 'billing_id', 'user_id'];

    public function orderItems()
    {
        return $this->hasMany('App\OrderItems', 'orders_id','id');
    }

    public function billing()
    {
        return $this->hasOne('App\Billing', 'id', 'billing_id');
    }
    
}
