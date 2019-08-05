<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = \Auth::user();
        if($user->can('update',\App\User::class))
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
            // 'uname'=>'required', 
            // 'email'=>'required'
        ];
    }

    public function messages()
    {
        return [
            // 'uname.required' => 'User name is required',
            // 'email.required' => 'Email is required'
        ];
    }
}