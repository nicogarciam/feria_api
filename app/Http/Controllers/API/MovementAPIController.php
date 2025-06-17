<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMovementAPIRequest;
use App\Http\Requests\API\UpdateMovementAPIRequest;
use App\Models\Balance;
use App\Models\Movement;
use App\Repositories\MovementRepository;
use Facades\App\Services\DataAccessValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MovementResource;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class MovementController
 * @package App\Http\Controllers\API
 */

class MovementAPIController extends AppBaseController
{
    /** @var  MovementRepository */
    private $movementRepository;

    public function __construct(MovementRepository $movementRepo)
    {
        $this->movementRepository = $movementRepo;
    }


    public function index(Request $request)
    {
        $movements = $this->movementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($movements);
    }


    public function balance(Request $request)
    {

        $input = $request->all();

        $balance = new Balance();
        $for = $input['for'];

        $for['store_id'] = isset($for['store_id']) ? $for['store_id'] : session('store_id');

        $valid = DataAccessValidation::validateStore($for['store_id']);

        if (!$valid) {
            return $this->sendError('unauthorized.store','403');
        }

        $date_from = $input['date_from'] ?? null;
        $balance_prev = $date_from ? $this->movementRepository->balance(null, $date_from, $for ) : 0;

        $date_to = $input['date_to'] ?? null;
        $movements = $this->movementRepository->allBetween($date_from, $date_to, $for);
        $balance->movements = $movements;
        $balance->balance_prev = $balance_prev;
        $balance->date_from = $date_from;
        $balance->date_to = $date_to;
        $balance->customer_id = isset($for['customer_id']) ?  $for['customer_id'] : null;
        $balance->store_id = isset($for['store_id']) ? $for['store_id'] : null;

        $balance_acum = $balance_prev;

        foreach ($movements as $move) {
            $balance_acum = $move->balance = $move->calculateBalance($balance_acum);
        }
        $balance->balance_final = $balance_acum;
        $balance->state = $balance->balance_final > 0 ? 'credit' : ($balance->balance_final < 0 ? 'debt' : 'settled');
        $balance->movements = $balance->movements->reverse()->values()->collect();
        return response()->json($balance);
    }



    public function store(CreateMovementAPIRequest $request)
    {
        $input = $request->all();

        $input['user'] = Auth::user()->email;
        $input['state'] = 'CREATED';

        $movement = $this->movementRepository->create($input);

        return response()->json($movement);
    }


    public function show($id)
    {
        /** @var Movement $movement */
        $movement = $this->movementRepository->find($id);

        if (empty($movement)) {
            return $this->sendError('Movement not found');
        }
        return response()->json($movement);
    }


    public function update($id, UpdateMovementAPIRequest $request)
    {
        $input = $request->all();

        $movement = $this->movementRepository->find($id);

        if (empty($movement)) {
            return $this->sendError('Movement not found');
        }

        $movement = $this->movementRepository->update($input, $id);

        return response()->json($movement);
    }

    public function destroy($id)
    {
        /** @var Movement $movement */
        $movement = $this->movementRepository->find($id);

        if (empty($movement)) {
            return $this->sendError('Movement not found');
        }

        $movement->delete();

        return $this->sendSuccess('Movement deleted successfully');
    }
}
