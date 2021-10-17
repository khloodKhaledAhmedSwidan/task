<?php

namespace App\Http\Requests\General;

use App\Http\Requests\MainRequest;

class ProductRequest extends MainRequest
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
            'category_id' => 'required|exists:categories,id',
        ];
    }

  
}
