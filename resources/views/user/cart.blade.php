@extends('user.master')

@section('content')
<div class="container">
    @if(Cart::count()>0)
    <h4>{{ Cart::count()}} item(s) in Shopping Cart</h4>
    <div id="cartMsg"></div>
    <div class="row">

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(Cart::count()>0)
                    @foreach(Cart::content() as $item)
                    <tr>
                        <td width="10%">
                            <img src="{{ asset('uploads/product/'. $item->model->image) }}" width="100%" alt="Image" style="height:70px;">
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <input type="hidden" value="{{ $item->rowId}}" id="rowId{{ $item->id }}">
                            <input type="number" name="qty" min="1" max="10" id="updateCart{{ $item->id }}"
                                value="{{ $item->qty }}">
                        </td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <a href="{{ route('remove', ['id'=>$item->rowId] )}}">Remove</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="height:570px; padding:100px">
                                <h3>No Items in the cart.</h3>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            </div>
                        </div>
                    </div>
                    @endif
                </tbody>
                <tfoot>
                    <tr style="background:#fffe">
                        <td colspan="2">&nbsp;</td>
                        <td>Subtotal</td>
                        <td>{{ Cart::subtotal() }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td>Tax</td>
                        <td>{{ Cart::tax() }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td>Total</td>
                        <td>{{ Cart::total() }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <a href="{{ route('index')}}" class="btn btn-primary">Continue Shopping</a>
            <a href=" {{ route('checkout') }}" class="btn btn-primary"> Proceed to Checkout</a>
        </div><br>

    </div>
    <div class="row">
        <h4>You may also like...</h4>
        @if(count($mightAlsoLike)>0)
            @foreach($mightAlsoLike as $k)
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <center>
                        <div class="thumbnail product-box">
                            <img src="{{ asset('uploads/product/'.$k['image']) }}" width="200px" alt="Image"
                                style="height:200px">
                            <div class="caption">
                                <h3><a href="#"> {{$k['product_name']}} </a></h3>
                                <p>Price : <strong>Rs {{$k['product_price']}} </strong> </p>
                                <p> {{$k['product_desc']}} </p>
                            </div>
                        </div>
                    </center>
                </div>
            @endforeach
        @endif
    </div>
    @else
    <h4>No items in the Cart</h4>
    @endif
</div>


<script>
$(document).ready(function() {
    @foreach(Cart::content() as $item)
        $('#updateCart{{$item->id}}').on('change keyup', function() {
            var newQty = $('#updateCart{{$item->id}}').val();
            var rowId = $('#rowId{{$item->id}}').val();
            $.ajax({
                url: '{{ url('update') }}',
                data: 'rowId=' + rowId + '&newQty=' + newQty,
                type: 'get',
                success: function(response) {
                    $('#cartMsg').html(response);
                }
            });
        });
    @endforeach
});
</script>
@stop