<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainRequest;

class LoginRequest extends MainRequest
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
            'phone' => 'required|exists:users,phone|numeric|digits_between:6,15',
            'password' => 'required|min:8',
            'device_token' => 'required',
          ];
    }
  
}
