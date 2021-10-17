<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'phone' => $this->phone != null ? strval($this->phone) : null,
            'email' => $this->email != null ? strval($this->email) : null,
            'token' => $this->when($this->token,$this->token),

        ];
    }
}
