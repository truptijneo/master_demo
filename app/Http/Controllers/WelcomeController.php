<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Category;
use App\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if(request()->has('category')){
            $products = Product::with('category')
                                    ->whereHas('category', function ($query) {
                                            $query->where('category_name', request('category'));
                                        })
                                    ->paginate(6);
        }else{
            $products = Product::with('category')->paginate(6);
        }

        if (request('sort') == 'low_high' ) {
            $products = Product::with('category')->orderBy('product_price', 'asc')->paginate(6);
        } elseif (request('sort') == 'high_low') {
            $products = Product::with('category')->orderBy('product_price', 'desc')->paginate(6);
        } else {
            $products = Product::with('category')->paginate(6);
        }

        // if(request()->has('category') || request('sort')){
        //     $products = Product::with('category')
        //                             ->whereHas('category', function ($query) {
        //                                     $query->where('category_name', request('category'));
        //                                 })
        //                             ->orderBy('product_price', 'desc')    
        //                             ->paginate(6);
        // }else{
        //     $products = Product::with('category')->paginate(6);
        // }
        

        return view('user.index', compact('products', 'categories'));                        
    }

    public function search(Request $request)
    {
        $categories = Category::all();
        $search = $request->get('search_term');
        $products = Product::where('product_name', 'LIKE', '%' . $search . '%')->with('category')->paginate(6);

        return view('user.index', compact('products', 'categories'));   
    }
}
