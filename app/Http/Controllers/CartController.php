<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Cart;
use App\Product;
use App\Billing;
use App\Order;

class CartController extends Controller
{
    public function index()
    {
        $mightAlsoLike =  Product::where('product_price', '>', 200)->inRandomOrder()->limit(4)->get();
        return view('user.cart', compact('mightAlsoLike'));
    }

    public function store(Request $request)
    { 
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request){
            return $cartItem->id === $request->id;
        });

        if($duplicates->isNotempty()){
            return redirect()
                    ->route('cart')
                    ->with('success', 'Item is already in your cart.');
        }

        Cart::add($request->id, $request->product_name, $request->product_quantity, $request->product_price)
                ->associate('App\Product');
        return redirect()
                ->route('cart')
                ->with('success', 'Item has been added to cart.');
    }

    public function update(Request $request)
    {
        $newQty = $request->newQty;
        $rowId = $request->rowId;
        $res = Cart::update($rowId, $newQty);
        return 'Cart updated successfully!';
    }
    
    public function destroy($id)
    {
        Cart::remove($id);
        return back()
                ->with('success', 'Item has been removed');
    }

    public function checkout()
    {
        return view('user.checkout');
    }

    public function emptyCart()
    {
        Cart::destroy();
        return redirect('cart')
                ->with('success', 'Your Cart has been Cleared!');
    }
}