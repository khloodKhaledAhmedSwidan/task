<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'is_send' => $this->is_send != null ? intval($this->is_send) : null,
            'cartProducts' => $this->cartProducts()->count() > 0 ?  CartProductResource::collection($this->cartProducts()->get()) : null,

        ];
    }
}
