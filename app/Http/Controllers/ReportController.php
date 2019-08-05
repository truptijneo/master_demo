<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Product;
use App\Category;
use App\Order;

use Carbon;

class ReportController extends Controller
{
    public static function usersReport()
    {
        $users = User::with('roles')->where('name', '!=', 'admin')->get();
        return view('vendor.adminlte.report.users_report', compact('users'));
    }

    public static function productsReport()
    {
        $products = Product::with('category')->get();
        return view('vendor.adminlte.report.products_report', compact('products'));
    }

    public static function totalOrdersReport()
    {
        $orders = Order::withTrashed()->get();
        return view('vendor.adminlte.report.orders_report', compact('orders'));
    }

    public static function todaysOrdersReport()
    {
        $date = Carbon\Carbon::now()->format('Y-m-d').'%';
        
        $orders = Order::where('created_at', 'like', $date)->withTrashed()->get();
        return view('vendor.adminlte.report.todays_orders_report', compact('orders'));
    }

    public static function pendingOrdersReport()
    {
        $orders = Order::where('order_status', 'LIKE', 'Pending')->get();
        return view('vendor.adminlte.report.pending_orders_report', compact('orders'));
    }

    public static function dispatchedOrdersReport()
    {
        $orders = Order::where('order_status', 'LIKE', 'Dispatched')->get();
        return view('vendor.adminlte.report.dispatched_orders_report', compact('orders'));
    }

    public static function inprogressOrdersReport()
    {
        $orders = Order::where('order_status', 'LIKE', 'In Progress')->get();
        return view('vendor.adminlte.report.inprogress_orders_report', compact('orders'));
    }

    public static function completedOrdersReport()
    {
        $orders = Order::where('order_status', 'LIKE', 'Completed')->get();
        return view('vendor.adminlte.report.completed_orders_report', compact('orders'));
    }

    public static function deliveredOrdersReport()
    {
        $orders = Order::where('order_status', 'LIKE', 'Delivered')->get();
        return view('vendor.adminlte.report.delivered_orders_report', compact('orders'));
    }

    public static function deletedOrdersReport()
    {
        $orders = Order::onlyTrashed()->get(); 
        return view('vendor.adminlte.report.deleted_orders_report', compact('orders'));
    }
}
