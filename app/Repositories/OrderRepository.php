<?php

namespace App\Repositories;

use App\Order;


class OrderRepository implements OrderRepositoryInterface
{
    public function get($order_id)
    {
        return Order::find($order_id);
    }

    public function all()
    {
        return Order::withTrashed()->orderBy('created_at', 'desc')->get();
    }

    public function update($order_id, array $order_data)
    {   
        Order::find($order_id)->update($order_data);
    }

    public function delete($order_id)
    {
        Order::destroy($order_id);
    }
}

?>