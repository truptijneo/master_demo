@extends('adminlte::page')

@section('title', 'Category')

@section('content_header')
<h1>Categories</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="table-responsive">
            <h4>Category Details</h4>
            @include('flash-message')
            <a href="{{ route('createCategory') }}" class="btn btn-primary pull-right">Add Category </a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php $count = 0; ?>
                    @if(count($category)>0)
                    @foreach($category as $k)
                    <tr>
                        <td>{{++$count}}</td>
                        <td>{{$k->category_name}}</td>
                        <td>
                            <a href="{{ route('editCategory', ['id'=>$k->id] )}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('deleteCategory', ['id'=>$k->id])}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="3">
                                <center>No category found.</center>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop