@extends('adminlte::page')

@section('title', 'Order')


@section('content')
<div class="container">
    <center><h5><b>Order Invoice</b></h5></center><br><br>
    <div class="row" style="border-bottom:1px solid gray">
        
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            Order No. : {{ $order['order_no'] }} <br>
            Order Date : {{ $order['order_date'] }}
        </div>
        
        <div class="col-xs-4 col-sm-2 col-md-4 col-lg-4"></div>
        
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 pull-right">
            Name : {{ $order->billing->name }} <br>
            Email : {{ $order->billing->email }} <br>
            Mobile : {{ $order->billing->mobile }} <br>
            Address : {{ ucfirst($order->billing->address) . ' ' . ucfirst($order->billing->city) . ' ' . $order->billing->pincode . '.'}} <br><br>
        </div>
        
    </div>
    <br><br>
    <div class="row" style="border-bottom:1px solid gray"> 
        <?php $count = 1; ?>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Product Name </th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @if(count($orderItems->orderItems)>0)
                    @foreach($orderItems->orderItems as $item)
                        <tr>
                            <td> {{ $count++ }}</td>
                            <td> {{ ucwords($item->product->product_name) }} </td>
                            <td> {{ $item['item_qty'] }}</td>
                            <td> {{ $item->product->product_price }} </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="2"></td>
                    <td>Subtotal</td>
                    <td> {{ $order['subtotal'] }} </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Tax</td>
                    <td> {{ $order['tax'] }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Total</td>
                    <td> {{ $order['order_total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <br><br>
    <a href="{{ route('getAllOrders')}}" class="btn btn-primary">Back</a>
</div>
@stop