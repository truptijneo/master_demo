<?php 

use App\User;
use App\Product;
use App\Order;

class Helper {
    public static function userCount()
    {
        $users = User::with('roles')->where('name', '!=', 'admin')->get();
        return count($users);
    }

    public static function productCount()
    {
        $products = Product::all();
        return count($products);
    }

    public static function orderCount()
    {
        $orders = Order::withTrashed()->get();
        return count($orders);
    }

    public static function pendingOrdersCount()
    {
        $orders = Order::where('order_status', 'LIKE', 'Pending')->get();
        return count($orders);
    }

    public static function dispatchedOrdersCount()
    {
        $orders = Order::where('order_status', 'LIKE', 'Dispatched')->get();
        return count($orders);
    }

    public static function inprogressOrdersCount()
    {
        $orders = Order::where('order_status', 'LIKE', 'In Progress')->get();
        return count($orders);
    }

    public static function completedOrdersCount()
    {
        $orders = Order::where('order_status', 'LIKE', 'Completed')->get();
        return count($orders);
    }

    public static function deliveredOrdersCount()
    {
        $orders = Order::where('order_status', 'LIKE', 'Delivered')->get();
        return count($orders);
    }

    public static function todaysOrdersCount()
    {
        $date = Carbon\Carbon::now()->format('Y-m-d').'%';
        
        $orders = Order::where('created_at', 'like', $date)->withTrashed()->get();
        return count($orders);
    }

    public static function latestOrders()
    {
        $orders = Order::orderBy('id', 'desc')->take(8)->get();
        return $orders;
    }

    public static function latestProducts()
    {
        $products = Product::orderBy('id', 'desc')->take(4)->get();
        return $products;
    }

    public static function monthlyWiseOrdersCount(){
        $monthlyWiseOrders = Order::selectRaw('monthname(created_at) month, count(*) data')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        return $monthlyWiseOrders;
    }

    public static function monthWiseIncome(){
        $monthWiseIncome = Order::selectRaw('monthname(created_at) month, sum(order_total) data')
                ->where('order_status', 'LIKE', 'Delivered')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        return $monthWiseIncome;
    }
}

?>