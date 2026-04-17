<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleItem;
use App\Models\Settlement;
use App\Repositories\SettlementRepository;
use Facades\App\Services\DataAccessValidation;
use App\Services\PaginationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettlementAPIController extends AppBaseController
{
    /** @var  SettlementRepository */
    private $settlementRepository;

    public function __construct(SettlementRepository $settlementRepository)
    {
        $this->settlementRepository = $settlementRepository;
    }

    /**
     * @SWG\Get(
     *      path="/settlements",
     *      summary="Get list of settlements",
     *      tags={"Settlements"},
     *      description="Get list of settlements with pagination and filtering",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="page",
     *          in="query",
     *          type="integer",
     *          description="Page number",
     *          default=1
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          in="query",
     *          type="integer",
     *          description="Records per page",
     *          default=10
     *      ),
     *      @SWG\Parameter(
     *          name="provider_id",
     *          in="query",
     *          type="integer",
     *          description="Filter by provider ID"
     *      ),
     *      @SWG\Parameter(
     *          name="status",
     *          in="query",
     *          type="string",
     *          enum={"pending", "paid", "cancelled"},
     *          description="Filter by status"
     *      ),
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          type="string",
     *          format="date",
     *          description="Start date for filtering"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          type="string",
     *          format="date",
     *          description="End date for filtering"
     *      ),
     *      @SWG\Parameter(
     *          name="sort_by",
     *          in="query",
     *          type="string",
     *          enum={"generated_at", "total_sales", "amount_to_pay"},
     *          description="Sort by field"
     *      ),
     *      @SWG\Parameter(
     *          name="sort_order",
     *          in="query",
     *          type="string",
     *          enum={"asc", "desc"},
     *          default="desc"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Settlement")
     *              ),
     *              @SWG\Property(
     *                  property="meta",
     *                  type="object",
     *                  @SWG\Property(property="total", type="integer"),
     *                  @SWG\Property(property="page", type="integer"),
     *                  @SWG\Property(property="last_page", type="integer")
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $search = $request->only(['provider_id', 'status', 'date_from', 'date_to','store_id']);
        $limit = $request->get('limit', 10);
        $page = $request->get('page', 1);
        $size = $request->get('size', 10);
        $sort = $request->get('sort', 'date,desc');

        // Convert sort parameter to array
        $orders = null;
        if ($sort) {
            $sortParts = explode(',', $sort);
            $orders = [];
            for ($i = 0; $i < count($sortParts); $i += 2) {
                if (isset($sortParts[$i + 1])) {
                    $orders[] = $sortParts[$i] . ',' . $sortParts[$i + 1];
                }
            }
        }

        $query = $this->settlementRepository->allSettlementsQuery(
            $search,
            $orders
        );

        return PaginationService::forAngular($query, $request);
    }

    /**
     * @SWG\Get(
     *      path="/settlements/preview",
     *      summary="Get settlement preview",
     *      tags={"Settlements"},
     *      description="Get settlement preview without saving",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="provider_id",
     *          in="query",
     *          type="integer",
     *          required=true,
     *          description="Provider ID"
     *      ),
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          type="string",
     *          format="date",
     *          required=true,
     *          description="Start date (Y-m-d)"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          type="string",
     *          format="date",
     *          required=true,
     *          description="End date (Y-m-d)"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Invalid input"
     *      )
     * )
     */
    public function preview(Request $request)
    {
        try {
            $preview = $this->settlementRepository->getSettlementPreview(
                $request->provider_id,
                $request->start_date,
                $request->end_date
            );

            return $this->sendResponse($preview, 'Settlement preview retrieved successfully');

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    /**
     * @SWG\Post(
     *      path="/settlements",
     *      summary="Create a settlement",
     *      tags={"Settlements"},
     *      description="Create a new settlement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Settlement data",
     *          required=true,
     *          @SWG\Schema(
     *              @SWG\Property(property="provider_id", type="integer", example=1),
     *              @SWG\Property(property="start_date", type="string", format="date", example="2026-04-01"),
     *              @SWG\Property(property="end_date", type="string", format="date", example="2026-04-30")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=201,
     *          description="Settlement created successfully"
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Invalid input"
     *      )
     * )
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $input = $request->all();

        // 🔐 Autorización
        if (!DataAccessValidation::validateStore($input['store_id'])) {
            return $this->sendError('unauthorized.store', '403');
        }

        $userId = Auth::id();

        try {

            $settlement = DB::transaction(function () use ($input, $userId) {


                $details = $input['settle_details'];

                $data = [
                    ...$input,
                    'generated_by' => $userId,
                ];

                if ($input['status'] === 'paid') {
                    $data['paid_at'] = now();
                    $data['paid_by'] = $userId;
                }

                if ($input['status'] === 'cancelled') {
                    $data['canceled_at'] = now();
                    $data['canceled_by'] = $userId;
                }

                $settlement = $this->settlementRepository->create($data);

                // 🔒 Procesar detalles con lock
                foreach ($details as $sd) {
                    $saleItem = SaleItem::lockForUpdate()->findOrFail($sd['sale_item_id']);

                    $settlement->seattle_details()->create([
                        ...$sd,
                        'settlement_id' => $settlement->id
                    ]);

                    $saleItem->update([
                        'settlement_id' => $settlement->id,
                        'settled' => true
                    ]);
                }

                return $settlement->fresh(['settle_details']);
            });

            return response()->json($settlement);

        } catch (\DomainException $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @SWG\Get(
     *      path="/settlements/{id}",
     *      summary="Get settlement details",
     *      tags={"Settlements"},
     *      description="Get detailed information about a specific settlement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="Settlement ID",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Settlement not found"
     *      )
     * )
     */
    public function show($id)
    {
        try {
            $settlement = Settlement::with(['store','provider','settle_details',
                'settle_details.sale_item.product'])->findOrFail($id);

            return response()->json($settlement);
        } catch (Exception $e) {
            return $this->sendError('Settlement not found', 404);
        }
    }

    /**
     * @SWG\Delete(
     *      path="/settlements/{id}",
     *      summary="Cancel a settlement",
     *      tags={"Settlements"},
     *      description="Cancel a settlement (only if status is pending)",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="Settlement ID",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Settlement cancelled successfully"
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Cannot cancel settlement"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Settlement not found"
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $settlement = $this->settlementRepository->cancelSettlement($id, auth()->id());

            return $this->sendResponse(
                $settlement,
                'Settlement cancelled successfully'
            );

        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'not found') !== false) {
                return $this->sendError('Settlement not found', 404);
            }
            return $this->sendError($e->getMessage(), 400);
        }
    }

    /**
     * @SWG\Get(
     *      path="/providers/pending-settlement",
     *      summary="Get providers with pending settlements",
     *      tags={"Settlements"},
     *      description="Get list of providers with unsettled sales for a period",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          type="string",
     *          format="date",
     *          description="Start date (Y-m-d)"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          type="string",
     *          format="date",
     *          description="End date (Y-m-d)"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *      )
     * )
     */
    public function providersPendingSettlement(Request $request)
    {
        try {
            $providers = $this->settlementRepository->getProvidersPendingSettlement(
                $request->get('start_date'),
                $request->get('end_date')
            );

            return response()->json($providers);

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @SWG\Put(
     *      path="/settlements/{id}/pay",
     *      summary="Mark settlement as paid",
     *      tags={"Settlements"},
     *      description="Mark a settlement as paid",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="Settlement ID",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Settlement marked as paid"
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Cannot mark settlement as paid"
     *      )
     * )
     */
    public function markAsPaid($id)
    {
        try {
            $settlement = $this->settlementRepository->markSettlementAsPaid($id, auth()->id());

            return $this->sendResponse(
                new $settlement,
                'Settlement marked as paid successfully'
            );

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
}
