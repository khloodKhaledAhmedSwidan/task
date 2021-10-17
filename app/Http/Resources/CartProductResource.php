<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => intval($this->id),
            'cart_id' => $this->cart_id  != null ? intval($this->cart_id) : null,
            'product_id' => $this->product_id  != null ? intval($this->product_id) : null,
            'product_details' => $this->product_id  != null ? new ProductResource(Product::where('id', $this->product_id)->first()) : null,
            'quantity' => $this->quantity  != null ? intval($this->quantity) : null,

        ];
    }
}
