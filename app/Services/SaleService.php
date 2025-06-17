<?php
namespace App\Services;


use App\Models\Movement;
use App\Models\Sale;
use App\Models\SaleStatuses;
use App\Repositories\MovementRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SaleService
{


    public function checkSaleState($payment)
    {
        if ($payment->booking_id) {
            $bo = Sale::find($payment->sale_id);
            if ($bo->booking_state->name == 'NEW' && $payment->type == 'SIGN') {

            }
        }
    }


    public static function setSaleState($sa, $newStateId, $event = null, $note = null, $new = false)
    {

        if (!$new){
            if ($sa->sale_state_id == $newStateId ) {
                return null;
            }
            $prev_state = $sa->sale_state;
            $prev_state->date_to = Carbon::now();
            $prev_state->save();
        }

        $newState = new SaleStatuses();
        $newState->event = $event;
        $newState->date_from = Carbon::now();
        $newState->state_id = $newStateId;
        $newState->sale_id = $sa->id;

        $newState->save();

        $sa->sale_state_id = $newState->state_id;
        $sa->save();
        return $newState;

    }

}
