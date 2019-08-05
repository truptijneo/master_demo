@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
<h1>Orders</h1>
@stop

@section('content')
<div class="container">
    <div class="row">        
        <div class="table-responsive">
            <h4>Order Details</h4>
            <table class="table table-bordered table-hover" id="dataList">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Order Id</th>
                    <th>Order Date</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Deleted At</th>
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
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>{{ $order->deleted_at }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">
                            <center>No orders found.</center>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>        
    </div>
</div>
@stop

@section('adminlte_js')
<script>
$(function() {
    $('#dataList').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ]
    });
});
</script>
@stop