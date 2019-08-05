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
            <table class="table table-hover" id="dataList">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Price</th>
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
                        <td>{{$k->image}}</td>                        
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5">
                            <center>No product found.</center>
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