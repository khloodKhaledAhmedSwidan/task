<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name != null ? strval($this->name) : null,
            'category_id' => $this->category_id  != null ? intval($this->category_id):null,
            'desc' => $this->desc  != null ? strval($this->desc):null,
            'price' => $this->price  != null ? floatval($this->price):null,
            'quantity' => $this->quantity  != null ? intval($this->quantity):null,
            'current_quantity' => $this->current_quantity  != null ? intval($this->current_quantity):null,
            'image' => $this->image != null ? asset('storage/products/' . $this->image) : null,

        ];
    }
}
