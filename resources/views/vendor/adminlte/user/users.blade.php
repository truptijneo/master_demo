@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
<h1>Users</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="table-responsive">
            <h4>User Details</h4>
             @if ($message = Session::get('message'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <h5><b>Below Email address has already been taken</b></h5>
                    @foreach ($message as $key=>$error)
                        <strong> {{$error }}</strong><br>
                    @endforeach
                </div>
             @endif

            @include('flash-message')
            
            <div class="pull-right">
                <form action="{{ route('importUserCSV') }}" method="POST" class="form-inline" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="sr-only" for="">label</label>
                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                        <input type="file" name="import_file" />
                    </div>
                    <button type="submit" class="btn btn-primary">Import File</button>
                </form><br>
            </div>

            <a href="{{ url('admin/export-users/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
            <a href="{{ url('admin/export-users/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>
            <a href="{{ url('admin/export-users/csv') }}"><button class="btn btn-success">Download CSV</button></a>
            <br><br>
            <table class="table table-hover table-responsive" id="dataList">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Role</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@stop

@section('adminlte_js')
<script>
$(function() {
               $('#dataList').DataTable({
               processing: true,
               serverSide: true,
               ajax: {
                  "url":  '{{ route('usersList') }}',
                  "type": "GET"
               },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' } ,
                        { data: 'role', name: 'name'},
                        { data: 'action', name: 'action', orderable: false, searchable: false}
                     ]
                     
            });
         });
</script>
@stop