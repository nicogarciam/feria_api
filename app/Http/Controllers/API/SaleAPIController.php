<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBookingAPIRequest;
use App\Http\Requests\API\CreateSaleAPIRequest;
use App\Http\Requests\API\UpdateBookingAPIRequest;
use App\Http\Requests\API\UpdateSaleAPIRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\BookingCode;
use App\Repositories\AccommodationPriceRepository;
use App\Repositories\SaleRepository;
use App\Services\BookingService;
use App\Services\MovementsService;
use App\Services\SaleService;
use Facades\App\Services\DataAccessValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SaleResource;
use Illuminate\Support\Facades\DB;
use Response;
use function PHPUnit\Framework\isEmpty;

/**
 * Class BookingController
 * @package App\Http\Controllers\API
 */

class SaleAPIController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/sales",
     *      summary="Get a listing of the Bookings.",

     */
    public function index_old(Request $request)
    {
        $sales = $this->saleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($sales);
//        return $this->sendResponse(SaleResource::collection($sales), 'Bookings retrieved successfully');
    }

    public function index(Request $request)
    {

        $states_ids = explode(',',$request->get('states'));
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');
        $storeId = $request->get('store_id');
        $search = $request->except(['skip','states','limit','date_from','date_to','filter_state']);
        $filter = $request->get('filter_state');

        $valid = DataAccessValidation::validateStore($storeId);

        if (!$valid) {
            return $this->sendError('unauthorized.store','403');
        }


        $sales = $this->saleRepository->allSalesQuery($search, $date_from, $date_to, $storeId);


        return response()->json($sales);
    }

    public function countResume(Request $request)
    {
        $states_ids = explode(',',$request->get('states'));
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');
        $store_id = $request->get('store_id');

        $valid = DataAccessValidation::validateStore($store_id);

        if (!$valid) {
            return $this->sendError('unauthorized.store','403');
        }

//        $countResume = $this->bookingRepository->bookingCountResume($date_from, $date_to, $hotelId , $states_ids);

        $filtersResume = $this->saleRepository->salesFiltersCountResume($date_from, $date_to, $store_id , $states_ids);

        return response()->json($filtersResume);
    }


    public function generateCode($id)
    {
        $booking = $this->saleRepository->find($id);

        if (empty($booking)) {
            return $this->sendError('Sale not found');
        }


        $booking->code = $this->saleRepository->generateCode($booking);
        return response()->json($booking);
    }



    public function store(CreateSaleAPIRequest $request)
    {
        $input = $request->all();

        $valid = DataAccessValidation::validateStore($input['store_id']);

        if (!$valid) {
            return $this->sendError('unauthorized.store','403');
        }

        $input['code'] = $this->saleRepository->generateCode($input);
        $input['user'] = auth()->user()->email;

        DB::beginTransaction();
        $sale_state_id = $input['sale_state_id'] = isset($input['state']) ? $input['state']['id'] : 1 ;
        $sale = $this->saleRepository->create($input);

        SaleService::setSaleState($sale, $sale_state_id,'sale_created',null, true);

        $sale_items = [];
        $products = $input['products'];
        foreach ($products as $p ) {
            $sale_items[] = array(
                'sale_id' => $sale->id,
                'product_id'   => $p['id'],
                'price'   => $p['price'],
            );

            DB::table('products')->where('id', $p['id'])->update(
                [
                    'price' =>  $p['price'],
                    'state_id' => $p['state_id']
                ]
            );
        }

        DB::table('sale_items')->insert($sale_items);

        DB::commit();

        return response()->json($this->saleRepository->find($sale->id, ['products']));
    }


    public function show($id)
    {

        $valid = DataAccessValidation::validateSale($id);

        if (!$valid) {
            return $this->sendError('unauthorized.sale','403');
        }

        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id, ['products']);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        return response()->json($sale);
//        return $this->sendResponse(new SaleResource($booking), 'Sale retrieved successfully');
    }


    public function update($id, UpdateSaleAPIRequest $request)
    {
        $input = $request->all();

        $valid = DataAccessValidation::validateSale($id);

        if (!$valid) {
            return $this->sendError('unauthorized.sale','403');
        }

        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $new_sale_state_id = $input['sale_state'];

        DB::beginTransaction();

        $sale = $this->saleRepository->update($input, $id);
        $new_sale_state = SaleService::setSaleState($sale, $new_sale_state_id,'sale_update',null, false);

        if ($new_sale_state_id == 2) {
            $products = $sale->products();
            foreach ($products as $product) {
                MovementsService::generateProviderCredit($product,$sale);
            }
        }
        $sale->save();

        DB::commit();
        $sale = $this->saleRepository->find($id);
        return response()->json($sale);

    }


    public function destroy($id)
    {

        $valid = DataAccessValidation::validateSale($id);

        if (!$valid) {
            return $this->sendError('unauthorized.sale','403');
        }
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $products = DB::table('sale_items')
            ->where('sale_id', $sale->id)
            ->pluck('product_id');

        // Actualizar el estado de los productos a disponible (asumiendo que el estado 1 es "disponible")
        DB::table('products')
            ->whereIn('id', $products)
            ->update(['state_id' => 1]);


        DB::table('sale_items')->where('sale_id','=',$sale->id)->delete();
        DB::table('movements')->where('sale_id','=',$sale->id)->delete();
        DB::table('sale_statuses')->where('sale_id','=',$sale->id)->delete();

        $sale->delete();

        return $this->sendSuccess('Sale deleted successfully');
    }
}
