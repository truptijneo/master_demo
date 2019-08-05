<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['product_name', 'product_price', 'category_id', 'product_desc'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItems', 'orders_id', 'id');
    }

}
