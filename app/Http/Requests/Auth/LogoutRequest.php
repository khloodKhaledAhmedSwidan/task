<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainRequest;

class LogoutRequest extends MainRequest
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
            'device_token' => 'required|exists:devices,device_token',
        ];
    }


}
