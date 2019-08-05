@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
<h1>Edit Role</h1>
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

    {!! Form::model($role, ['method' => 'PATCH','route' => ['updateRole', $role->id], 'data-parsley-validate', 'id' => 'updateRoleForm']) !!}
    <div class="row">
        <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <label>Role</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 ">
                {!! Form::text('name', null, [
	              'class'                         => 'form-control',
	              'required'                      => 'required',
	              'placeholder'                   => 'Role Name',
	              'data-parsley-required-message' => 'Role is required',
	              'data-parsley-trigger'          => 'change focusout',
	              'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
	              'data-parsley-minlength'        => '2',
	              'data-parsley-maxlength'        => '32',
	              'data-parsley-class-handler'    => '#name-group'
	              ]) !!}
    
                {!! $errors->first('name','<p class="help-block">:message</p>') !!}
            </div>
        </div><br>
        <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <label>Guard Name</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 ">
                {!! Form::text('guard_name', null, [
	              'class'                         => 'form-control',
	              'required'                      => 'required',
	              'placeholder'                   => 'Guard Name',
	              'data-parsley-required-message' => 'Guard name is required',
	              'data-parsley-trigger'          => 'change focusout',
	              'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
	              'data-parsley-minlength'        => '2',
	              'data-parsley-maxlength'        => '32',
	              'data-parsley-class-handler'    => '#guard_name-group'
	              ]) 
                !!}
                {!! $errors->first('guard_name','<p class="help-block">:message</p>') !!}
            </div>
        </div><br><br>
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            {!! Form::submit('Submit', [
                'class' => 'btn btn-primary', 'id' => 'submitBtn'
                ]) 
            !!}  
            <a href="{{ route('roles') }}" class="btn btn-primary">Back</a>      
        </div>
    </div>
    {!! Form::close() !!}
    
</div>
@stop

@section('adminlte_js')
<script>
$(document).ready(function() {
    $('#updateRoleForm').parsley().on('field:validated', function() {
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