@extends('user.master')

@section('content')

<div class="container">
    <h3>Order Details</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Order Id</th>
                    <th>Order Date</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                @if(count($orders)>0)
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->subtotal }}</td>
                        <td>{{ $order->tax }}</td>
                        <td>{{ $order->order_total }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td>
                            <a href="{{ route('order', ['id'=>$order->id]) }}">View</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">
                            <center>No orders found.</center>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@endsection