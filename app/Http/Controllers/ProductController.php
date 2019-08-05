<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageServiceProvider;

use App\Http\Requests\Product\ProductViewRequest;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\Product\ProductDeleteRequest;

use App\Product;
use App\Category;

//use Validator;

use Excel;

class ProductController extends Controller 
{
    public function index(ProductViewRequest $request) 
    {
        $products = Product::with('category')->get(); 
        return view('vendor.adminlte.product.products', array('products' => $products));
    }

    public function createProduct()
    {
        $category = Category::all();
        return view('vendor.adminlte.product.add_product', compact('category'));
    }

    // Insert product
    public function addProduct(ProductCreateRequest $req) 
    { 
        $product = new Product();
        $product->category_id = $req->get('category_id');
        $product->product_name = $req->get('product_name');
        $product->product_price = $req->get('product_price');
        $product->total_quantity = $req->get('total_quantity');
        $product->product_desc = $req->get('product_desc');

        if($req->hasFile('image')){
            $image = $req->file('image');
            $filename = time(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product/'), $filename);
           $product->image = $filename;
        }else{
            return $req;
            $product->image = '';
        }

        $res = $product->save();
        if($res){
            return redirect()
                    ->route('products')
                    ->with('success', 'Product added successfully!');
        }else{
            return redirect()
                    ->route('products')
                    ->with('error', 'Something went wrong.');
        }

    }

    public function editProduct(ProductUpdateRequest $request, $id) 
    {
        $product = Product::find($id);
        return view('vendor.adminlte.product.edit_product', compact('product'));
    }

    // Update product
    public function updateProduct(ProductUpdateRequest $request, $id) 
    {
        //$validator = Validator::make($request->all(), $request->rules(), $request->messages());

        $product = Product::find($id);

        if(!empty($product)){

        }else{
            return redirect()
                    ->route('products')
                    ->with('error', 'Product not found.');
        }
        
        $product->product_name = $request->get('product_name');
        $product->product_price = $request->get('product_price');
        $product->product_desc = $request->get('product_desc');
        $product->total_quantity = $request->get('total_quantity');       
        $product->available_quantity = $request->get('total_quantity') - $product->sold_out;
               
        if($request->hasFile('image')){
            $image = $req->file('image');
            $filename = time(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product/'), $filename);
           $product->image = $filename;
        }else{
            $product->image = '';
        }

        $res = $product->save();
        if($res){
            return redirect()
                    ->route('products')
                    ->with('success', 'Product updated successfully!');
        }else{
            return redirect()
                    ->route('products')
                    ->with('error', 'Something went wrong.');
        }
    }

    // Delete product
    public function deleteProduct(ProductDeleteRequest $request, $id) 
    {
        $product = Product::find($id); 
        
        $res = $product->delete();
        if($res){
            return redirect()
                    ->route('products')
                    ->with('success', 'Product deleted successfully!');
        }else{
            return redirect()
                    ->route('products')
                    ->with('error', 'Something went wrong.');
        }
    }

    // Out of stock products 
    public function productsOutOfStock(ProductViewRequest $request) 
    {
        $products = Product::where('total_quantity', '=', 0)->with('category')->get(); 
        return view('vendor.adminlte.product.products_out_of_stock', array('products' => $products));
    }

    // Import CSV file
    public function importCSV(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);

        $path = $request->file('import_file')->getRealPath();
        
        $data = \Excel::load($path)->get();

        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = [
                            'product_name' => $value->product_name,
                            'product_price' => $value->product_price,
                            'product_desc' => $value->product_desc,
                            'category_id' => $value->category_id,
                            'total_quantity' => $value->total_quantity                           
                         ];
            }
 
            if(!empty($arr)){
                Product::insert($arr);
            }
        }
 
        return back()->with('success');
    }
}
