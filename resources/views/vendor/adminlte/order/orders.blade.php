@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<h1>Orders</h1>
@stop

@section('content')
<div class="container">
    <div class="row">        
        <div class="table-responsive">
            <h4>Order Details</h4>
            @include('flash-message')
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
                        <td>
                            <?php $order_status = $order->order_status; ?>
                            <select class="changeStatus" id="{{ $order->id }}">
                                <option value="Pending" <?php if($order_status == 'Pending') echo 'selected'; ?>>Pending</option>   
                                <option value="Dispatched" <?php if($order_status == 'Dispatched') echo 'selected'; ?>>Dispatched</option>   
                                <option value="In Progress" <?php if($order_status == 'In Progress') echo 'selected'; ?>>In Progress</option>   
                                <option value="Completed" <?php if($order_status == 'Completed') echo 'selected'; ?>>Completed</option>   
                                <option value="Delivered" <?php if($order_status == 'Delivered') echo 'selected'; ?>>Delivered
                                </option>   
                            </select>
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>{{ $order->deleted_at }}</td>
                        <td>
                            <a href="{{ route('getOrder', ['id'=>$order->id]) }}"><i class="fa fa-eye btn btn-primary"></i></a>
                            <a href="{{ route('deleteOrder', ['id'=>$order->id]) }}"><i class="fa fa-trash btn btn-danger"></i></a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
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
    $(document).ready(function(){
        $('#dataList').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.changeStatus').on('change', function(){
            var id = $(this).attr('id');
            var status = $(this).children('option:selected').val();
            
            $.ajax({
                'type' : 'POST',
                'url' : '/admin/change-order-status',
                'data' :{id:id, status:status},
                'dataType': 'json',
                success : function(data){
                    console.log(data);
                    if(data === true){
                        alert('Order status has been changed!');
                    }else{
                        alert('Error in changing order status.');
                    }
                }
            });
        });
    });
</script>
@stop