<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDiscountAPIRequest;
use App\Http\Requests\API\UpdateDiscountAPIRequest;
use App\Models\Discount;
use App\Repositories\DiscountRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DiscountResource;
use Response;

/**
 * Class DiscountController
 * @package App\Http\Controllers\API
 */

class DiscountAPIController extends AppBaseController
{
    /** @var  DiscountRepository */
    private $discountRepository;

    public function __construct(DiscountRepository $discountRepo)
    {
        $this->discountRepository = $discountRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/discounts",

     */
    public function index(Request $request)
    {
        $discounts = $this->discountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($discounts);
//        return $this->sendResponse(DiscountResource::collection($discounts), 'Discounts retrieved successfully');
    }

    /**
     * @param CreateDiscountAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/discounts",
     *      summary="Store a newly created Discount in storage",
     *      tags={"Discount"},
     *      description="Store Discount",

     */
    public function store(CreateDiscountAPIRequest $request)
    {
        $input = $request->all();

        $discount = $this->discountRepository->create($input);

        return response()->json($discount);
//        return $this->sendResponse(new DiscountResource($discount), 'Discount saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/discounts/{id}",
     *      summary="Display the specified Discount",

     */
    public function show($id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepository->find($id);

        if (empty($discount)) {
            return $this->sendError('Discount not found');
        }

        return response()->json($discount);
//        return $this->sendResponse(new DiscountResource($discount), 'Discount retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDiscountAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/discounts/{id}",
     *      summary="Update the specified Discount in storage",

     */
    public function update($id, UpdateDiscountAPIRequest $request)
    {
        $input = $request->all();

        /** @var Discount $discount */
        $discount = $this->discountRepository->find($id);

        if (empty($discount)) {
            return $this->sendError('Discount not found');
        }

        $discount = $this->discountRepository->update($input, $id);

        return response()->json($discount);
//        return $this->sendResponse(new DiscountResource($discount), 'Discount updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/discounts/{id}",
     *      summary="Remove the specified Discount from storage",
     *      tags={"Discount"},
     *      description="Delete Discount",
     *      produces={"application/json"},

     */
    public function destroy($id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepository->find($id);

        if (empty($discount)) {
            return $this->sendError('Discount not found');
        }

        $discount->delete();

        return $this->sendSuccess('Discount deleted successfully');
    }
}
