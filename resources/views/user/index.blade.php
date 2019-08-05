@extends('user.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div>
                <a href="#" class="list-group-item active">Categories </a>
                <ul class="list-group">
                    @foreach($categories as $cat)
                    <li class="list-group-item">
                        <a href="{{ route('index', ['category' => $cat->category_name]) }}">{{ $cat->category_name }}</a>
                    </li>
                    @endforeach                
                </ul>
            </div>
            <br>
            <div class="divider"></div>
            <div>
                <a href="#" class="list-group-item active">Price </a>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ route('index', ['category'=> request()->category, 'sort' => 'low_high']) }}">Low Price</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('index', ['category'=> request()->category, 'sort' => 'high_low']) }}">High Price</a>
                    </li>
                </ul>
            </div>
        </div>
       
        <!-- <a href="{{url('/send/email')}}">Mail</a> -->
        <div class="col-md-9">
            <div class="row">
                    <form action="{{ route('search') }}" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search_term"
                                placeholder="Search product"> <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
            </div><br>
            @if(count($products)>0)
                <div class="row">
                    @foreach($products as $k)
                    <div class="col-md-4 text-center col-sm-6 col-xs-6">
                        <div class="thumbnail product-box">
                            <!-- <img src="assets/img/dummyimg.png" alt="" /> -->
                            <img src="{{ asset('uploads/product/'.$k['image']) }}" width="200px" alt="Image" style="height:200px">
                            <div class="caption">
                                <h3><a href="#"> {{$k['product_name']}} </a></h3>
                                <p>Price : <strong>Rs {{$k['product_price']}} </strong> </p>
                                <p> {{$k['product_desc']}} </p>
                                <p>
                                    <!-- <a href="#" class="btn btn-success" role="button">Add To Cart</!--> 
                                    <!-- <a href="{{ route('showProduct', ['id'=>$k['id']] )}}" class="btn btn-primary" role="button">See Details</a> -->
                                </p>
                                <form action="{{ route('addToCart')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $k['id'] }}">
                                    <input type="hidden" name="image" value="{{ $k['image'] }}">
                                    <input type="hidden" name="product_name" value="{{$k['product_name']}}">
                                    <input type="hidden" name="product_price" value="{{$k['product_price']}}">
                                    <input type="hidden" name="product_quantity" value="1">
                                    @if($k['total_quantity'] == 0)
                                        <input class="btn btn-danger" type="button" value="Out Of Stock">
                                    @else
                                        <input name="addToCart" class="btn btn-primary" type="submit" value="Add to Cart">
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            @else
                No product found.
            @endif
        </div>
    </div>
</div>

@stop