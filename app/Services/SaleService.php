<?php
namespace App\Services;


use App\Models\Movement;
use App\Models\Sale;
use App\Models\SaleState;
use App\Models\SaleStatuses;
use App\Repositories\MovementRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class SaleService
{


    public static function checkSaleState($payment, $event = "update")
    {
        if ($payment->sale_id) {
            $sa = Sale::find($payment->sale_id);
            if (!$sa) return;
            $paid = $sa->total_paid();
            $newStateID = $paid >= $sa->total_price ? SaleState::PAID : ($paid < $sa->total_price ? SaleState::CONFIRMED : $sa->sale_state_id);
            if ($sa->sale_state_id !== $newStateID) {
                SaleService::setSaleState($sa, $newStateID, $event, null, true);
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
        $newState->user_email = auth()->user()->email;

        $newState->save();

        $sa->sale_state_id = $newState->state_id;
        $sa->save();
        return $newState;

    }

}
