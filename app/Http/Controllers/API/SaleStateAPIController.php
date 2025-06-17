<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleAPIRequest;
use App\Repositories\SaleStateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\BookingStateResource;
use Response;

/**
 * Class BookingStateController
 * @package App\Http\Controllers\API
 */

class SaleStateAPIController extends AppBaseController
{
    /** @var  SaleStateRepository */
    private $saleStateRepository;

    public function __construct(SaleStateRepository $saleStateRepo)
    {
        $this->saleStateRepository = $saleStateRepo;
    }

    public function index(Request $request)
    {
        $saleStates = $this->saleStateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return response()->json($saleStates);
    }

    public function store(CreateSaleAPIRequest $request)
    {
        $input = $request->all();

        $saleState = $this->saleStateRepository->create($input);

        return response()->json($saleState);

    }

    public function show($id)
    {
        $saleState = $this->saleStateRepository->find($id);

        if (empty($saleState)) {
            return $this->sendError('Sale State not found');
        }

        return response()->json($saleState);
    }


    public function update($id, UpdateBookingStateAPIRequest $request)
    {
        $input = $request->all();

        $saleState = $this->saleStateRepository->find($id);

        if (empty($saleState)) {
            return $this->sendError('Sale State not found');
        }

        $saleState = $this->saleStateRepository->update($input, $id);

        return response()->json($saleState);
    }


    public function destroy($id)
    {
        $saleState = $this->saleStateRepository->find($id);

        if (empty($saleState)) {
            return $this->sendError('Sale State not found');
        }

        $saleState->delete();

        return $this->sendSuccess('Sale State deleted successfully');
    }



    public function findSaleHistoric($saleId)
    {
        $saleStates = $this->saleStateRepository->findSaleHistoric($saleId);
        return response()->json($saleStates);
    }


    public function findByStore($storeId)
    {
        $saleStates = $this->saleStateRepository->all();
        return response()->json($saleStates);
    }


    public function findByHotel($storeId = null, $type = 'SIMPL')
    {

        $saleStates = $this->saleStateRepository->allFull(['store_id' => $storeId]);

        return response()->json($saleStates);
    }
}
