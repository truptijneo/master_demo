<?php
namespace App\Repositories;

interface OrderRepositoryInterface
{
    public function get($order_id);

    public function all();

    public function update($order_id, array $order_data);

    public function delete($order_id);
}

?>