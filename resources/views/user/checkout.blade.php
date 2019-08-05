@extends('user.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="bs-callout bs-callout-warning hidden">
                <h4>Oh snap!</h4>
                <p>This form seems to be invalid :(</p>
            </div>

            <div class="bs-callout bs-callout-info hidden">
                <h4>Yay!</h4>
                <p>Everything seems to be ok :)</p>
            </div>

            <form id="payment-form" action="{{ route('placeOrder') }}" method="post" class="form-horizontal" role="form"
                data-parsley-validate="">
                <div class="form-group">
                    <legend>Billing Details</legend>
                    {{ csrf_field() }}
                </div>
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" 
                        data-parsley-minwords="3"                        
                        data-parsley-maxwords="20"
                         data-parsley-required-message="Name is required"
                        value="{{ auth()->user()->name }}" required="">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" id="email" 
                        data-parsley-trigger="change"
                        data-parsley-required-message="Email is required" 
                        value="{{ auth()->user()->email }}" required="">
                </div>
                <div class="form-group">
                    <label>Mobile:</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" 
                      data-parsley-type="digits"
                        data-parsley-regexp="#[0-9]{10}" 
                        data-parsley-minlength="10" 
                        data-parsley-maxlength="10"
                        data-parsley-required-message="Mobile number is required" required="">
                </div>
                <div class="form-group">
                    <label>Address:</label>
                    <input type="text" class="form-control" name="address" id="address"
                        data-parsley-required-message="Address is required" required="">
                </div>
                <div class="form-group">
                    <label>City:</label>
                    <input type="text" class="form-control" name="city" id="city"
                        data-parsley-required-message="City is required" required="">
                </div>
                <div class="form-group">
                    <label>Pincode:</label>
                    <input type="text" class="form-control" name="pincode" id="pincode" 
                        data-parsley-type="digits"
                        data-parsley-minlength="6" data-parsley-maxlength="6"
                        data-parsley-required-message="Pincode is required" required="">
                </div>
                <br>
                <div class="form-group">
                        <legend>Payment Details</legend>
                    </div>
                <div class="form-group">
                    <label for="card-element">
                    Credit or debit card
                    </label>
                    <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div>
            </form>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-3">
            <legend>Order Details</legend>
                    @if(Cart::count()>0)
                    @foreach(Cart::content() as $item)
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('uploads/product/'. $item->model->image) }}" width="100%" alt="Image"
                                style="height:40px;">
                        </div>
                        <div class="col-md-7">
                            {{ $item->name }} <br>
                            Rs. {{ $item->price }}
                        </div>
                        <div class="col-md-1">{{ $item->qty }}</div>
                    </div><br>
                    @endforeach
                    <hr>
                    <div class="row">
                        <div class="col-md-3">Subtotal</div>
                        <div class="col-md-3"></div>
                        <div class="col-md-5 pull-right">Rs. {{ Cart::subtotal() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Tax</div>
                        <div class="col-md-3"></div>
                        <div class="col-md-5 pull-right">Rs. {{ Cart::tax() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Total</div>
                        <div class="col-md-3"></div>
                        <div class="col-md-5 pull-right">Rs. {{ Cart::total() }}</div>
                    </div>
                    @else
                    <h4>Cart is empty.</h4>
                    @endif
        </div>
    </div>
</div>
<script>
    // Create a Stripe client.
var stripe = Stripe('pk_test_xGQ4fMkwOxlQCJS32KR4S52U00NpoPXW7u');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {
    style: style,
    hidePostalCode : true
});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

     var options = {
        name: document.getElementById('user_name').value,
        mobile: document.getElementById('mobile').value,
        address: document.getElementById('address').value,
        city: document.getElementById('city').value,
        pincode: document.getElementById('pincode').value
    };

  stripe.createToken(card, options).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>
@stop