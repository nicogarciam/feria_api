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
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'store_id' => $this->store_id,
            'category_id' => $this->category_id,
            'provider_id' => $this->provider_id,
            'state_id' => $this->state_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
