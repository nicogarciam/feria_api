<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCouponAPIRequest;
use App\Http\Requests\API\UpdateCouponAPIRequest;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CouponResource;
use Response;

/**
 * Class CouponController
 * @package App\Http\Controllers\API
 */

class CouponAPIController extends AppBaseController
{
    /** @var  CouponRepository */
    private $couponRepository;

    public function __construct(CouponRepository $couponRepo)
    {
        $this->couponRepository = $couponRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/coupons",
     *      summary="Get a listing of the Coupons.",
     *      tags={"Coupon"},
     *      description="Get all Coupons",
     *      produces={"application/json"},
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function index(Request $request)
    {
        $coupons = $this->couponRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CouponResource::collection($coupons), 'Coupons retrieved successfully');
    }

    /**
     * @param CreateCouponAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/coupons",
     *      summary="Store a newly created Coupon in storage",
     *      tags={"Coupon"},
     *      description="Store Coupon",
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function store(CreateCouponAPIRequest $request)
    {
        $input = $request->all();

        $coupon = $this->couponRepository->create($input);

        return $this->sendResponse(new CouponResource($coupon), 'Coupon saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/coupons/{id}",
     *      summary="Display the specified Coupon",
     *      tags={"Coupon"},
     *      description="Get Coupon",

          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function show($id)
    {
        /** @var Coupon $coupon */
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            return $this->sendError('Coupon not found');
        }

        return $this->sendResponse(new CouponResource($coupon), 'Coupon retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCouponAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/coupons/{id}",
     *      summary="Update the specified Coupon in storage",
     *      tags={"Coupon"},
     *      description="Update Coupon",
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function update($id, UpdateCouponAPIRequest $request)
    {
        $input = $request->all();

        /** @var Coupon $coupon */
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            return $this->sendError('Coupon not found');
        }

        $coupon = $this->couponRepository->update($input, $id);

        return $this->sendResponse(new CouponResource($coupon), 'Coupon updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/coupons/{id}",
     *      summary="Remove the specified Coupon from storage",
     *      tags={"Coupon"},
     *      description="Delete Coupon",
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function destroy($id)
    {
