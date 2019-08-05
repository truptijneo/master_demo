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
            <table class="table table-hover" id="dataList">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    @if(count($users)>0)
                    @foreach($users as $k)
                    <tr>
                        <td>{{++$count}}</td>
                        <td>{{$k->name}} </td>
                        <td>{{$k->email}}</td>
                        <td>{{$k->created_at}}</td>
                        <td>{{$k->updated_at}}</td>
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                <center>No user found.</center>
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