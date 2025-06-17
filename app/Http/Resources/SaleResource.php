<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'hotel_id' => $this->hotel_id,
            'guest_id' => $this->guest_id,
            'booking_state_id' => $this->booking_state_id,
            'date_in' => $this->date_in,
            'date_out' => $this->date_out,
            'note' => $this->note,
            'pax' => $this->pax,
            'pax_adult' => $this->pax_adult,
            'pax_minor' => $this->pax_minor,
            'accommodation_count' => $this->accommodation_count,
            'coupon_code' => $this->coupon_code,
            'days_to_confirm' => $this->days_to_confirm,
            'days_to_cancel' => $this->days_to_cancel,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
