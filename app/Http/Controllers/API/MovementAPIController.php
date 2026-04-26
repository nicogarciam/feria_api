<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMovementAPIRequest;
use App\Http\Requests\API\UpdateMovementAPIRequest;
use App\Models\Balance;
use App\Models\Movement;
use App\Repositories\MovementRepository;
use App\Services\MovementsService;
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
        $for = $input['for'] ?? [];

        $storeId = $for['store_id'] ?? session('store_id');
        $valid = DataAccessValidation::validateStore($storeId);

        if (!$valid) {
            return $this->sendError('unauthorized.store', '403');
        }

        // 1. Identificar Sujeto y Criterios
        $balanceCriteria = ['store_id' => $storeId];
        $queryCriteria = ['store_id' => $storeId];

        $subjects = ['user_id', 'customer_id', 'provider_id', 'cash_account_id'];
        $foundSubject = null;
        foreach ($subjects as $s) {
            if (isset($for[$s])) {
                $foundSubject = $s;
                break;
            }
        }

        if (!$foundSubject) {
            // Balance de Tienda: Sujeto = Caja por Defecto
            $defaultAccount = MovementsService::getDefaultCashAccount($storeId);
            if ($defaultAccount) {
                $balanceCriteria['cash_account_id'] = $defaultAccount->id;
                $balance->cash_account_name = $defaultAccount->name;
            }
            // queryCriteria queda solo con store_id para devolver todos los movimientos de la tienda
        } else {
            // Balance Específico: Sujeto = Filtro enviado
            $balanceCriteria[$foundSubject] = $for[$foundSubject];
            $queryCriteria[$foundSubject] = $for[$foundSubject];
        }

        $date_from = $input['date_from'] ?? null;
        $date_to = $input['date_to'] ?? null;

        // 2. Obtener Balance Previo y Movimientos
        // Usamos balanceCriteria para el saldo acumulado previo
        $balance_prev = $date_from ? $this->movementRepository->balance(null, $date_from, $balanceCriteria) : 0;

        // Usamos queryCriteria para obtener los movimientos a mostrar
        $movements = $this->movementRepository->allBetween($date_from, $date_to, $queryCriteria);

        $balance->movements = $movements;
        $balance->balance_prev = $balance_prev;
        $balance->date_from = $date_from;
        $balance->date_to = $date_to;
        $balance->customer_id = $for['customer_id'] ?? null;
        $balance->store_id = $storeId;

        // 3. Bucle de Acumulación Condicional
        $balance_query = 0;
        $balance_acumulado = $balance_prev;

        // return response()->json($balanceCriteria);
        foreach ($movements as $move) {
            // Solo influyen en el saldo si coinciden con los criterios de balance
            if ($move->matchesCriteria($balanceCriteria)) {
                $balance_query +=  $move->getMovement();
                $balance_acumulado = $move->calculateBalance($balance_acumulado);
                $move->apply_balance = true;
            } else {
                // Si no influye, el movimiento mantiene el saldo acumulado actual
                $move->balance = 0;
                $move->apply_balance = false;
            }
        }
        $balance->balance_query = $balance_query;
        $balance->balance_final = $balance_prev + $balance_query;
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
