<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       $user = \Auth::user();
        if($user){
            if($user->can('update', \App\Category::class)){
                return true;
            }
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
        //    'category_name'=>'required'
        ];
    }

    public function messages()
    {
        return [
        //    'category_name.required' => 'Category name is required'
        ];
    }
}
