<?php

namespace App\Http\Resources;

use App\Models\CartProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id  != null ? intval($this->user_id ) : null,
            'cart_id' =>  $this->cart_id  != null ? intval($this->cart_id ) : null,
            'cartDetails' => $this->cart_id  != null ? CartProductResource::collection(CartProduct::where('cart_id',$this->cart_id)->get()):null,
            'address'  => $this->address != null ? strval($this->address):null,
            'status'  => $this->status != null ? strval($this->status):null,
            'total'  => $this->total != null ? floatval($this->total):null,


        ];
    }
}
