@extends('adminlte::page')

@section('title', 'Add Category')

@section('content_header')
<h1>Categories</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="bs-callout bs-callout-warning hidden">
            <h4>Oh snap!</h4>
            <p>This form seems to be invalid :(</p>
        </div>

        <div class="bs-callout bs-callout-info hidden">
            <h4>Yay!</h4>
            <p>Everything seems to be ok :)</p>
        </div>

        <form id="addCategoryForm" action="{{ route('addCategory') }}" method="POST" class="form-horizontal"
            role="form">
            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
            <legend>Add Category</legend>
            <div class="form-group">
                <label class="col-sm-2">Category Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="category_name" placeholder="Category"
                        data-parsley-minwords="3" data-parsley-maxwords="20"
                        data-parsley-required-message="Category name is required" required="">
                        {!! $errors->first('category_name','<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                    <a href="{{ route('categories') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#addCategoryForm').parsley().on('field:validated', function() {
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