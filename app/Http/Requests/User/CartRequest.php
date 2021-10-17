<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;


class CartRequest extends MainRequest
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
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:0|not_in:0',
        ];
    }


}
