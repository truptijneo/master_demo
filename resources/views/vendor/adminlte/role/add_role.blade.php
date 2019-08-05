@extends('adminlte::page')

@section('title', 'Add Role')

@section('content_header')
<h1>Roles</h1>
@stop

@section('content')
<div class="container">
    <div class='row'>
        <div class='col-md-6'>
            {!! form($form) !!}
            <a href="{{ route('roles') }}" class="btn btn-primary">Back</a>
        </div>
        <div class='col-md-6'></div>
    </div>
</div>
    
@endsection
