<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = \Auth::user();
        
        if($user->can('update', \App\Product::class)){
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'product_name'=>'required', 
            // 'product_price'=>'required|numeric|min:5',
            // 'product_desc'=>'required',
            // 'total_quantity'=>'required|numeric|min:5',
            // 'image'=>'required|image|mimes:jpeg, png, jpg, gif, svg|max:2000048'
        ];
    }

    public function messages()
    {
        return [
            // 'product_name.required' => 'Product name is required',
            // 'product_price.required' => 'Product price is required',
            // 'product_desc.required' => 'Product description is required',
            // 'total_quantity.required' => 'Product quantity is required',
            // 'image.required' => 'Product image is required'
        ];
    }
}
