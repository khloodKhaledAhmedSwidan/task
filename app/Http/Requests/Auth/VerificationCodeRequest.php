<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class VerificationCodeRequest extends MainRequest
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
            'phone' => 'required|exists:users,phone',
            'device_token' => 'required',
            'code'    => 'required|exists:users,verification_code',
         
        ];
    }
}
