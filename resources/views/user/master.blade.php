<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Inventory Management</title>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('user/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Fontawesome core CSS -->
    <link href="{{asset('user/css/font-awesome.min.css')}}" rel="stylesheet" />
    <!--GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!--Slide Show Css -->
    <link href="{{asset('user/ItemSlider/css/main-style.css')}}" rel="stylesheet" />
    <!-- custom CSS here -->
    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet" />
    <!--Extra Show CSS -->
    <link href="{{asset('css/extra_css.css')}}" rel="stylesheet"/>

    <!--Core JavaScript file  -->
    <script src="{{asset('user/js/jquery-1.10.2.js')}}"></script>
    <!--bootstrap JavaScript file  -->
    <script src="{{asset('user/js/bootstrap.js')}}"></script>

    <!--Slider JavaScript file  -->
    <script src="{{asset('user/ItemSlider/js/modernizr.custom.63321.js')}}"></script>
    <script src="{{asset('user/ItemSlider/js/jquery.catslider.js')}}"></script>
    <script src="{{ asset('js/parsley.min.js')}}" type="text/javascript"></script>

    <!--Payment JavaScript file  -->
    <script src="https://js.stripe.com/v3/"></script>
    <style>

    .StripeElement {
    box-sizing: border-box;

    height: 40px;

    padding: 16px 16px;

    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: white;

    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
    /* box-shadow: 0 1px 3px 0 #cfd7df; */
    }

    .StripeElement--invalid {
    border-color: red;
    }

    .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
    }

    #card-errors{
        color:red;
    }

    .container{
        min-height:580px;
    }
</style>
</head>

<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('index')}}"><strong>DIGI</strong> Shop</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">24x7 Support 
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><strong>Call: </strong>+09-456-567-890</a></li>
                            <li><a href="#"><strong>Mail: </strong>info@yourdomain.com</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="#"><strong>Address: </strong>
                                    <div>
                                        234, New york Street,<br />
                                        Just Location, USA
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (Auth::check())
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Welcome {{ auth()->user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(auth()->user()->roles as $role)
                                @if($role->name == 'user')
                                    <li><a href="{{ route('cart') }}">Cart</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('orders') }}">Orders</a></li>
                                    <li class="divider"></li>
                                @endif
                                @if($role->name == 'admin')
                                    <li><a href="{{ route('adminhome') }}">Dashboard</a></li>
                                    <li class="divider"></li>
                                @endif
                            @endforeach
                            <li>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}"
                                    method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                    {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            </li>                                                     
                        </ul>
                    </li>
                    @else
                    <li><a href="{{ url(config('adminlte.register_url', 'register')) }}">Signup</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    @endif
                </ul>
                <!-- <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" placeholder="Enter Keyword Here ..." class="form-control">
                    </div>
                    &nbsp; 
                    <button type="submit" class="btn btn-primary">Search</button>
                </form> -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    @yield('content')

    <!--Footer -->
    <!-- /.col -->
    <div class="col-md-12 end-box text-center">
        &copy; 2014 | &nbsp; All Rights Reserved | &nbsp; www.yourdomain.com | &nbsp; 24x7 support | &nbsp; Email us:
        info@yourdomain.com
    </div>
    <!-- /.col -->
    <!--Footer end -->

    <script>
    $(function() {
        $('#mi-slider').catslider();
    });
    </script>
</body>
</html>