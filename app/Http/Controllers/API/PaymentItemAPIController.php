<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentItemAPIRequest;
use App\Http\Requests\API\UpdatePaymentItemAPIRequest;
use App\Models\PaymentItem;
use App\Repositories\PaymentItemRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PaymentItemResource;
use Response;

/**
 * Class PaymentItemController
 * @package App\Http\Controllers\API
 */

class PaymentItemAPIController extends AppBaseController
{
    /** @var  PaymentItemRepository */
    private $paymentItemRepository;

    public function __construct(PaymentItemRepository $paymentItemRepo)
    {
        $this->paymentItemRepository = $paymentItemRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/paymentItems",
     *      summary="Get a listing of the PaymentItems.",
     *      tags={"PaymentItem"},
     *      description="Get all PaymentItems",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/PaymentItem")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $paymentItems = $this->paymentItemRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PaymentItemResource::collection($paymentItems), 'Payment Items retrieved successfully');
    }

    /**
     * @param CreatePaymentItemAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/paymentItems",
     *      summary="Store a newly created PaymentItem in storage",
     *      tags={"PaymentItem"},
     *      description="Store PaymentItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PaymentItem that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PaymentItem")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/PaymentItem"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePaymentItemAPIRequest $request)
    {
        $input = $request->all();

        $paymentItem = $this->paymentItemRepository->create($input);

        return $this->sendResponse(new PaymentItemResource($paymentItem), 'Payment Item saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/paymentItems/{id}",
     *      summary="Display the specified PaymentItem",
     *      tags={"PaymentItem"},
     *      description="Get PaymentItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PaymentItem",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/PaymentItem"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var PaymentItem $paymentItem */
        $paymentItem = $this->paymentItemRepository->find($id);

        if (empty($paymentItem)) {
            return $this->sendError('Payment Item not found');
        }

        return $this->sendResponse(new PaymentItemResource($paymentItem), 'Payment Item retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePaymentItemAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/paymentItems/{id}",
     *      summary="Update the specified PaymentItem in storage",
     *      tags={"PaymentItem"},
     *      description="Update PaymentItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PaymentItem",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PaymentItem that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PaymentItem")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/PaymentItem"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePaymentItemAPIRequest $request)
    {
        $input = $request->all();

        /** @var PaymentItem $paymentItem */
        $paymentItem = $this->paymentItemRepository->find($id);

        if (empty($paymentItem)) {
            return $this->sendError('Payment Item not found');
        }

        $paymentItem = $this->paymentItemRepository->update($input, $id);

        return $this->sendResponse(new PaymentItemResource($paymentItem), 'PaymentItem updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/paymentItems/{id}",
     *      summary="Remove the specified PaymentItem from storage",
     *      tags={"PaymentItem"},
     *      description="Delete PaymentItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PaymentItem",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
