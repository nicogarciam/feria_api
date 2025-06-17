<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovementResource extends JsonResource
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
            'date' => $this->date,
            'booking_id' => $this->booking_id,
            'client_id' => $this->client_id,
            'account_id' => $this->account_id,
            'concept' => $this->concept,
            'amount' => $this->amount,
            'type' => $this->type,
            'state' => $this->state,
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
