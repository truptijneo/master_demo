@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
<h1>Products</h1>
@stop

@section('content')
<div class="container"><br>
    <div class="row">
        <div>
            <div class="pull-left">
                <h4>Product Details</h4>
            </div><br><br>
            @if ($errors->any())
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @else
                @include('flash-message')
            @endif
            <div class="pull-right">
            
            <form action="{{ route('importCSV') }}" method="POST" class="form-inline" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="sr-only" for="">label</label>
                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                    <input type="file" name="import_file" />
                </div>
                <button type="submit" class="btn btn-primary">Import File</button>
            </form><br>
                <a href="{{ route('createProduct') }}" class="btn btn-primary pull-right">Add Product</a><br>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix"></div><br>
        <div class="table-responsive">

            

            <table class="table table-hover" id="dataList">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
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
                        <td>
                            <img src="{{ asset('uploads/product/'.$k->image) }}" width="20px" alt="Image"
                                style="height:20px">
                        </td>
                        <td>
                            <a href="{{ route('editProduct', ['id'=>$k->id] )}}" class="btn btn-primary"><i
                                    class="fa fa-edit"></i></a>
                            <a href="{{ route('deleteProduct', ['id'=>$k->id]) }}" class="btn btn-danger"><i
                                    class="fa fa-trash"></i></a>
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

@section('adminlte_js')
<script>
$(function() {
    $('#dataList').DataTable();
});
</script>
@stop