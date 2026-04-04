<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentStateAPIRequest;
use App\Http\Requests\API\UpdatePaymentStateAPIRequest;
use App\Models\PaymentState;
use App\Repositories\PaymentStateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PaymentStateResource;
use Response;

/**
 * Class PaymentStateController
 * @package App\Http\Controllers\API
 */

class PaymentStateAPIController extends AppBaseController
{
    /** @var  PaymentStateRepository */
    private $paymentStateRepository;

    public function __construct(PaymentStateRepository $paymentStateRepo)
    {
        $this->paymentStateRepository = $paymentStateRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/paymentStates",
     *      summary="Get a listing of the PaymentStates.",
     *      tags={"PaymentState"},
     *      description="Get all PaymentStates",
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
     *                  @SWG\Items(ref="#/definitions/PaymentState")
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
        $paymentStates = $this->paymentStateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PaymentStateResource::collection($paymentStates), 'Payment States retrieved successfully');
    }

    /**
     * @param CreatePaymentStateAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/paymentStates",
     *      summary="Store a newly created PaymentState in storage",
     *      tags={"PaymentState"},
     *      description="Store PaymentState",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PaymentState that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PaymentState")
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
     *                  ref="#/definitions/PaymentState"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePaymentStateAPIRequest $request)
    {
        $input = $request->all();

        $paymentState = $this->paymentStateRepository->create($input);

        return $this->sendResponse(new PaymentStateResource($paymentState), 'Payment State saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/paymentStates/{id}",
     *      summary="Display the specified PaymentState",
     *      tags={"PaymentState"},
     *      description="Get PaymentState",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PaymentState",
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
     *                  ref="#/definitions/PaymentState"
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
        /** @var PaymentState $paymentState */
        $paymentState = $this->paymentStateRepository->find($id);

        if (empty($paymentState)) {
            return $this->sendError('Payment State not found');
        }

        return $this->sendResponse(new PaymentStateResource($paymentState), 'Payment State retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePaymentStateAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/paymentStates/{id}",
     *      summary="Update the specified PaymentState in storage",
     *      tags={"PaymentState"},
     *      description="Update PaymentState",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PaymentState",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PaymentState that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PaymentState")
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
     *                  ref="#/definitions/PaymentState"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePaymentStateAPIRequest $request)
    {
        $input = $request->all();

        /** @var PaymentState $paymentState */
        $paymentState = $this->paymentStateRepository->find($id);

        if (empty($paymentState)) {
            return $this->sendError('Payment State not found');
        }

        $paymentState = $this->paymentStateRepository->update($input, $id);

        return $this->sendResponse(new PaymentStateResource($paymentState), 'PaymentState updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/paymentStates/{id}",
     *      summary="Remove the specified PaymentState from storage",
     *      tags={"PaymentState"},
     *      description="Delete PaymentState",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PaymentState",
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
