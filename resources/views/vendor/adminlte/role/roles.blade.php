@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
<h1>Role</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="table-responsive">
            <h4>Role Details</h4>
            @include('flash-message')
            <a href="{{ route('createRole') }}" class="btn btn-primary pull-right">Add Role </a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php $count = 0; ?>
                    @foreach($roles as $k)
                    <tr>
                        <td>{{++$count}}</td>
                        <td>{{$k->name}}</td>
                        <td>{{ $k->guard_name }}</td>
                        <td>
                            <a href="{{ route('editRole', ['id'=>$k->id] )}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('deleteRole', ['id'=>$k->id])}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop