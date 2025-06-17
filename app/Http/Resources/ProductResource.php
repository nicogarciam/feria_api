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
            'name' => $this->name,
            'description' => $this->description,
            'capacity_desc' => $this->capacity_desc,
            'capacity' => $this->capacity,
            'hotel_id' => $this->hotel_id,
            'accommodation_type_id' => $this->accommodation_type_id,
            'accommodation_state_id' => $this->accommodation_state_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
