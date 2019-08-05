@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Dashboard</h1>
<style>
.canvasjs-chart-credit {
    display: none;
}
</style>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><span class="name">{{ \Helper::userCount() }}</span></h3>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <!-- <a href="{{ route('products') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><span class="name">{{ \Helper::productCount() }}</span></h3>

                <p>Total Products</p>

            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></!-->
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><span class="name">{{ \Helper::orderCount() }}</span></h3>

                <p>Total Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></!-->
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><span class="name">{{ \Helper::todaysOrdersCount() }}</span></h3>
                <p>Today's Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-md-5">
        <legend>Order Status</legend>
        <canvas id="order_status"></canvas>
    </div>
    <div class="col-md-7">
        <legend>Order Fullfillment</legend>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <legend>Monthly Orders</legend>
        <div id="monthlyOrders" style="height: 370px; width: 100%;"></div>
    </div>
</div><br>
<div class="row">
    <div class="col-md-12">
        <legend>Monthly Income</legend>
        <div id="monthWiseIncome" style="height: 370px; width: 100%;"></div>
    </div>
</div>

<div class="clearfix"></div>
<br><br>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $latestOrders = \Helper::latestOrders() ?>
                            @foreach($latestOrders as $k)
                            <tr>
                                <td><a href="{{ route('getOrder', ['id'=>$k->id]) }}">{{$k->order_no}}</a></td>
                                <td>{{$k->order_date}}</td>
                                <td>{{$k->order_total}}</td>
                                <td>
                                    <?php $order_status = $k->order_status; ?>
                                    @if($order_status == 'Pending')
                                    <span class="badge btn-danger">{{$k->order_status}}</span>
                                    @elseif($order_status == 'Dispatched')
                                    <span class="badge btn-primary">{{$k->order_status}}</span>
                                    @elseif($order_status == 'In Progress')
                                    <span class="badge btn-warning">{{$k->order_status}}</span>
                                    @elseif($order_status == 'Completed')
                                    <span class="badge btn-success">{{$k->order_status}}</span>
                                    @else
                                    <span class="badge btn-dark">{{$k->order_status}}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{ route('getAllOrders') }}" class="btn btn-sm btn-info float-left">View All Orders</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recently Added Products</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <?php $latestProducts = \Helper::latestProducts() ?>
                    @foreach($latestProducts as $k)
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ asset('uploads/product/'.$k->image) }}" class="img-size-50" alt="Image">
                        </div>
                        <div class="product-info">
                            <a class="product-title"> {{ $k->product_name }}
                                <span class="badge badge-warning" style="float:right;margin-right:25px"> Rs.
                                    {{ $k->product_price }} </span>
                            </a>
                            <span class="product-description">
                                {{ $k->product_desc }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('products') }}" class="btn btn-sm btn-info float-right">View All Products</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
@stop

@section('adminlte_js')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script>
var pendingOrdersCount = '{{ \Helper::pendingOrdersCount() }}';
var dispatchedOrdersCount = '{{ \Helper::dispatchedOrdersCount() }}';
var inprogressOrdersCount = '{{ \Helper::inprogressOrdersCount() }}';
var completedOrdersCount = '{{ \Helper::completedOrdersCount() }}';
var deliveredOrdersCount = '{{ \Helper::deliveredOrdersCount() }}';

var ctxD = document.getElementById("order_status").getContext('2d');
var myLineChart = new Chart(ctxD, {
    type: 'doughnut',
    data: {
        labels: ["Pending", "Dispatched", "In Progress", "Completed", "Delivered"],
        datasets: [{
            data: [pendingOrdersCount, dispatchedOrdersCount, inprogressOrdersCount,
                completedOrdersCount, deliveredOrdersCount
            ],
            backgroundColor: ["#F7464A", "#5AD3D1", "#FDB45C", "#00a65a", "#4D5360"],
            hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#00a65a", "#616774"]
        }]
    },
    options: {
        responsive: true
    }
});

window.onload = function() {
    <?php
        $dataPoints = array( 
            array("label"=>"Products", "y"=> \Helper::productCount()),
            array("label"=>"Order Pending", "y"=> \Helper::pendingOrdersCount()),
            array("label"=>"Order Dispatched", "y"=> \Helper::dispatchedOrdersCount()),
            array("label"=>"Order In Progress", "y"=> \Helper::inprogressOrdersCount()),
            array("label"=>"Completed Order", "y"=> \Helper::completedOrdersCount()),
            array("label"=>"Order Delivered", "y"=> \Helper::deliveredOrdersCount())
        )
    ?>

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        data: [{
            type: "pyramid",
            indexLabel: "{label} - {y}",
            yValueFormatString: "#,##0",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    <?php
        $months_arr = array(
            'January' => 0, 
            'February' => 0, 
            'March' => 0, 
            'April' => 0, 
            'May' => 0, 
            'June' => 0, 
            'July' => 0, 
            'August' => 0, 
            'September' => 0, 
            'October' => 0, 
            'November' => 0, 
            'December' => 0
        );
        $mcount = \Helper::monthlyWiseOrdersCount(); 
        $a = $res = $monthlyOrdersDataPoints = array();
        foreach($mcount as $k){ 
            $a[$k->month] = $k->data;
        }

        foreach($months_arr as $month => $name){
            if(array_key_exists($month, $a)){
                $res[$month] = $a[$month];
            }else{
                $res[$month] = 0;
            }
        }
    
        foreach($res as $key => $value){
            $new = array("y" => $value, "label" => $key );
            array_push($monthlyOrdersDataPoints, $new);
        }
    ?>

    var chart = new CanvasJS.Chart("monthlyOrders", {
        animationEnabled: true,
        theme: "light2",
        axisY: {
            title: "Orders Count"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.##",
            dataPoints: <?php echo json_encode($monthlyOrdersDataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    <?php 
        $mcount = \Helper::monthWiseIncome(); 
      
        $a = $res = $monthlyIncomeDataPoints = array();
        foreach($mcount as $k){ 
            $a[$k->month] = $k->data;
        }

        foreach($months_arr as $month => $name){
            if(array_key_exists($month, $a)){
                $res[$month] = $a[$month];
            }else{
                $res[$month] = 0;
            }
        }
    
        foreach($res as $key => $value){
            $new = array("y" => $value, "label" => $key );
            array_push($monthlyIncomeDataPoints, $new);
        }
    ?>

    var income_chart = new CanvasJS.Chart("monthWiseIncome", {
        animationEnabled: true,
        theme: "light2",
        axisY: {
            title: "Income"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.##",
            dataPoints: <?php echo json_encode($monthlyIncomeDataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    income_chart.render();
}
</script>
@stop