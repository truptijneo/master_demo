<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = \Auth::user();
        if($user->can('update',\App\Role::class))
        {
            return true;
        }else{
            return false;   
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'name'=>'required', 
            //'guard_name'=>'required'
        ];
    }

    public function messages()
    {
        return [
            //'name.required' => 'Role is required',
            //'guard_name.required' => 'Guard name is required'
        ];
    }
}