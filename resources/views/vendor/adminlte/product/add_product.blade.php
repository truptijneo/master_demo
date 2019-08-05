@extends('adminlte::page')

@section('title', 'Add Product')

@section('content_header')
<h1>Products</h1>
@stop

@section('content')

<div class="container">
    <div class="bs-callout bs-callout-warning hidden">
            <h4>Oh snap!</h4>
            <p>This form seems to be invalid :(</p>
        </div>

        <div class="bs-callout bs-callout-info hidden">
            <h4>Yay!</h4>
            <p>Everything seems to be ok :)</p>
        </div>

    <div class="row">
        <form id="addProductForm" action="{{ route('addProduct') }}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            
            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
            <legend>Add Product</legend>
            <div class="form-group">
                <label class="col-sm-2">Category Name</label>
                <div class="col-sm-10">
                    <select class="form-control" name="category_id" required="">
                        <option>Select category</option>
                        @foreach($category as $k)
                        <option value="{{$k->id}}">{{$k->category_name}}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('category_id','<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Product Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="product_name" placeholder="Product name"
                     data-parsley-minwords="3" data-parsley-maxwords="20"
                     data-parsley-required-message="Product name is required" required="">
                    {!! $errors->first('product_name','<p class="help-block">:message</p>') !!}
                 </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Product Price</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="product_price" placeholder="Product price" min="5" minlength="1" maxlength="5" 
                    data-parsley-type="digits"
                    data-parsley-minlength="1" data-parsley-maxlength="5"
                    data-parsley-required-message="Product price is required" required="">
                    {!! $errors->first('product_price','<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Product Quantity</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="total_quantity" id="total_quantity" data-parsley-type="digits"
                        data-parsley-regexp="#[0-9]{10}" data-parsley-minlength="1" data-parsley-maxlength="5"
                        data-parsley-required-message="Product quantity is required" required="">
                    {!! $errors->first('total_quantity','<p class="help-block">:message</p>') !!}
                </div>    
            </div>
            <div class="form-group">
                <label class="col-sm-2">Product Description</label>
                <div class="col-sm-10">
                    <textarea rows="2" cols="4" class="form-control" name="product_desc" placeholder="Product description"  
                        parsley-rangelength="[20,200]" required=""></textarea>
                    {!! $errors->first('product_desc','<p class="help-block">:message</p>') !!}
               </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Product Iamge</label>
                <div class="col-sm-10">
                    <input type="file" name="image"
                    accept="image/*"
                    data-parsley-validate
                    data-parsley-trigger="change"
                    data-parsley-required="true" required="">
                    {!! $errors->first('image','<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                    <a href="{{ route('products') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#addProductForm').parsley().on('field:validated', function() {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    })
    .on('form:submit', function() {
        return true;
    });
});
</script>
@stop