<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayItemResource extends JsonResource
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
            'concept' => $this->concept,
            'date' => $this->date,
            'paid' => $this->paid,
            'amount' => $this->amount,
            'ref_id' => $this->ref_id,
            'pay_id' => $this->pay_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
