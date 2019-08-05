<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['orders_id', 'product_id', 'item_name', 'item_price', 'item_qty'];

    public function orders()
    {
        return $this->belongsTo('App\Order', 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
