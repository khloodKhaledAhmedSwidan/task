<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'image' => $this->image != null ? asset('storage/categories/' . $this->image) : null,

        ];
    }
}
