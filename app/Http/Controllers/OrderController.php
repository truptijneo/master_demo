<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OrderRepositoryInterface;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

use App\Http\Requests\Order\OrderViewRequest;
use App\Http\Requests\Order\OrderDeleteRequest;

use Cart;
use Stripe;
use PDF;
use Notification;

use App\Billing;
use App\Order;
use App\Product;
use App\OrderItems;

use Cartalyst\Stripe\Exception\CardErrorException;
use App\Notifications\MyFirstNotification;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderRepositoryInterface $order) {
        $this->order = $order;
        // Stripe::setApiKey('sk_test_ECm7kgses1R2VDdZgHF9K48100MjTDDetX');
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function mail()
    {
        // $mail = Mail::send('email.order_mail', ['title' => 'Test', 'content' => 'Tesing my first mail'], function ($message)
        // {
        //     $message->from('trupti.sonar111@gmail.com', 'Christian Nwamba');
        //     $message->to('trupti.jade@neosofttech.com');
        // });
        
        $mail = Mail::to('trupti.jade@neosofttech.com')->send(new SendMailable('Test', 'Tesing my first mail'));

        dd($mail);
        if($mail){
            echo 'sent';
        }else{
            echo 'error';
        }
    }

    public function placeOrder(Request $request)
    { 
        $last_order_id = 0;

        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                           'name'=>'required|min:3|max:20',
                           'email'=>'required',
                           'mobile'=>'required',
                           'address'=>'required',
                           'city'=>'required',
                           'pincode'=>'required' 
                        ]);

            if($validator->fails()){
                return redirect('/user/checkout')
                                ->withErrors($validator)
                                ->withInput();
            }

            $billing = new Billing();
            
            $user_name = $request->get('user_name');
            $email = $request->get('email');
            $mobile = $request->get('mobile');
            $address = $request->get('address');
            $city = $request->get('city');
            $pincode = $request->get('pincode');

            $billing_details = Billing::where('email', $email)->get()->first(); 

            if(!empty($billing_details)){
                $billing_id = $billing_details['id'];
                $billing_details->name = $user_name;
                $billing_details->email = $email;
                $billing_details->mobile = $mobile;
                $billing_details->address = $address;
                $billing_details->city = $city;
                $billing_details->pincode = $pincode;
                $billing_details->user_id = auth()->user()->id; 

                $res = $billing_details->update();
            }else{
                $billing->name = $user_name;
                $billing->email = $email;
                $billing->mobile = $mobile;
                $billing->address = $address;
                $billing->city = $city;
                $billing->pincode = $pincode;
                $billing->user_id = auth()->user()->id; 

                $res = $billing->save();
                $billing_id = $billing->id;
            }
            
            if($res === true && $billing_id){  
                $charge = Stripe::charges()->create([
                    'amount' => Cart::total() / 1,
                    'currency' => 'CAD',
                    'source' => $request->stripeToken,
                    'description' => 'Order',
                    'receipt_email' => $billing->email,
                    'meta_data' => []
                ]);
                
                $last_order_id = Order::all()->last()->id; 

                $order = new Order();
                $order->order_no = '#' . str_pad(($last_order_id+1), 8, "0", STR_PAD_LEFT);
                $order->order_date = date('Y-m-d');
                $order->subtotal = Cart::subtotal();
                $order->tax = Cart::tax();
                $order->order_total = Cart::total();
                $order->billing_id = $billing_id;
                $order->payment_id = $charge['id'];
                $order->user_id = auth()->user()->id;

                $order_res = $order->save();
                $order_id = $order->id;

                if($order_res  === true && $order_id){
                    foreach(Cart::content() as $item){
                        $order_items = new OrderItems();
                        $order_items->orders_id = $order_id;
                        $order_items->product_id = $item->id;
                        $order_items->item_qty = $item->qty;
                        
                        $order_items_res = $order_items->save();

                        $product = Product::find($item->id);
                        $product->available_quantity = $product->total_quantity - ($product->available_quantity + $item->qty);
                        $product->sold_out = $product->total_quantity - $product->available_quantity;
                        $product_res = $product->save();
                    }
                }

                $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => 'This is my first notification from Digi.com',
                    'thanks' => 'Thank you for using Digi Shop!',
                    'actionText' => 'View Order',
                    'actionURL' => url('/'),
                    'order_id' => $order_id
                ];
  
                //Notification::send($order, new MyFirstNotification($details));

                return redirect('/user/thankyou');
            }else{
                return redirect('/checkout');
            }
        }else{
            return view('user.checkout'); 
        }
    }

    public function thankyou()
    {
        Cart::destroy();
        return view('user.thankyou'); 
    }

    public function orders()
    {
        $user_id = auth()->user()->id;
        $orders = Order::where('user_id', $user_id)->get();
        return view('user.home', compact('orders')); 
    }

    public function order($id)
    { 
        $order = $this->order->get($id); 

        if(!empty($order)){
            $orderItems = Order::with('orderItems')
                            ->find($id);

            $products = Product::with('orderItems')
                                ->find($id);
            
            $data = [
                'order' => $order,
                'orderItems' => $orderItems,
                'products' => $products,
                'title' => 'Order Invoice',
                'heading' => 'Hello from 99Points.info',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'        
            ];
        
            $pdf = PDF::loadView('user.order', $data);  
            
            return $pdf->stream('invoice.pdf');
        }else{
            return redirect()
                    ->route('orders');
        }
    }

    public function getAllOrders(OrderViewRequest $request)
    { 
        $orders = $this->order->all();
        return view('vendor.adminlte.order.orders', compact('orders')); 
    }

    public function getOrder(OrderViewRequest $request, $id)
    {
        $order = $this->order->get($id); 

        if(!empty($order)){
            $orderItems = Order::with('orderItems')
                            ->find($id);

            $products = Product::with('orderItems')
                                ->find($id);

            return view('vendor.adminlte.order.order', compact('order', 'orderItems', 'products'));
        }else{
            return redirect()
                    ->route('adminhome');
        }
    }

    // Update order status
    public function changeOrderStatus(Request $request)
    {
        $id = $request->id;
        $order = Order::find($id);
        
        $order->order_status = $request->status;
        $result = $order->update();
        return json_encode($result);
    }

    // Delete order
    public function deleteOrder(OrderDeleteRequest $request, $id) 
    {
        $order = $this->order->get($id); 
        
        $res = $order->delete();
        if($res){
            return redirect()
                    ->route('getAllOrders')
                    ->with('success', 'Order deleted.');
        }else{
            return redirect()
                    ->route('getAllOrders')
                    ->with('error', 'Something went wrong.');
        }
    }
    
}