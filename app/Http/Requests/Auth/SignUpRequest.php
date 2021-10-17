<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SignUpRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
  
        return [
            'name' => 'required|string|max:225',
            'password' => 'required|min:8|confirmed',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|numeric|digits_between:6,15|unique:users,phone',
        ];
    }


}
