<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\Category\CategoryViewRequest;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Requests\Category\CategoryDeleteRequest;

use App\Category;

class CategoryController extends Controller 
{
    public function index(CategoryViewRequest $request) 
    {
        $category = Category::all();        
        return view('vendor.adminlte.category.categories', compact('category'));
    }
    
    public function createCategory(Request $request)
    {
        return view('vendor.adminlte.category.add_category');
    }

    // Create new category
    public function addCategory(CategoryCreateRequest $request) 
    {
        $categories = Category::get()->pluck('category_name')->toArray(); 
        $category_name = $request->get('category_name');

        if(!in_array($category_name, $categories)){
            $category = new Category;
            $category->category_name = $category_name;

            try{
                $res = $category->save();

                $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => 'This is my first notification from ItSolutionStuff.com',
                    'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
                    'actionText' => 'View My Site',
                    'actionURL' => url('/'),
                    'order_id' => 101
                ];
        
                //Notification::send($category, new MyFirstNotification($details));

                if($res){
                    return redirect('/admin/categories')
                            ->with('success', 'Category saved successfully!');
                }else{
                    return redirect('/admin/categories')
                            ->with('error', 'Something went wrong.');
                }
            }catch(QueryException $e){
                if($e->errorInfo[1] == 1062){
                    return redirect('/admin/categories')
                            ->with('error', 'Category name must be unique.');
                }else{
                    throw $e;
                }
            }
        }else{
            return redirect('/admin/categories')
                    ->with('error', 'Category already exist.');
        }
    }

    public function editCategory(CategoryUpdateRequest $request, $id) 
    {
        $category = Category::find($id); 
        if(!empty($category)){
            return view('vendor.adminlte.category.edit_category', compact('category'));
        }else{
            return redirect('/admin/categories')
                    ->with('error', 'Category not found.');
        }
    }

    // Update category
    public function updateCategory(CategoryUpdateRequest $request, $id) 
    {
        $category = Category::find($id);
        
        if(!empty($category)){
            $categories = Category::get()->pluck('category_name')->toArray(); 
            $category_name = $request->get('category_name');

            if(!in_array($category_name, $categories)){
                $category->category_name = $category_name;

                try{
                    $res = $category->update();

                    if($res){
                        return redirect('/admin/categories')
                                ->with('success', 'Category updated successfully!');
                    }else{
                        return redirect('/admin/categories')
                                ->with('error', 'Something went wrong.');
                    }
                }catch(QueryException $e){
                    if($e->errorInfo[1] == 1062){
                        return redirect('/admin/categories')
                                ->with('error', 'Category name must be unique.');
                    }else{
                        throw $e;
                    }
                }
            }else{
                return redirect('/admin/categories')
                                ->with('error', 'Category already exist.');
            }
        }else{
            return redirect('/admin/categories')
                    ->with('error', 'Category not found.');
        }
    }

    // Delete category
    public function deleteCategory(CategoryDeleteRequest $request, $id) 
    {
        $category = Category::find($id); 
        
        if(!empty($category)){
            try{
                $res = $category->delete();
                if($res){
                    return redirect('/admin/categories')
                            ->with('success', 'Category deleted successfully!');
                }else{
                    return redirect('/admin/categories')
                            ->with('error', 'Something went wrong.');
                }
            }catch(QueryException $e){
                throw $e;
            }
        }else{
            return redirect('/admin/categories')
                    ->with('error', 'Category not found.');
        }
    }
}
