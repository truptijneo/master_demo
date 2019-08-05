@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
<h1>Products</h1>
@stop

@section('content')
<div class="container">
    <div class="row">        
        <div class="table-responsive">
            <h4>Product Details</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Total Quantity</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    @if(count($products)>0)
                    @foreach($products as $k)
                    <tr>
                        <td>{{++$count}}</td>
                        <td>{{$k->category->category_name}} </td>
                        <td>{{$k->product_name}}</td>
                        <td>{{$k->product_price}}</td>  
                        <td>{{$k->total_quantity}}</td>
                        <td>
                            <img src="{{ asset('uploads/product/'.$k->image) }}" width="20px" alt="Image" style="height:20px">
                        </td>
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <center>No products found.</center>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>        
    </div>
</div>
@stop