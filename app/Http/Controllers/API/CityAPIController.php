<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCityAPIRequest;
use App\Http\Requests\API\UpdateCityAPIRequest;
use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CityResource;
use Response;

/**
 * Class CityController
 * @package App\Http\Controllers\API
 */

class CityAPIController extends AppBaseController
{
    /** @var  CityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/cities",
     *      summary="Get a listing of the Cities.",

     */
    public function index(Request $request)
    {
        $cities = $this->cityRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($cities);
//        return $this->sendResponse(CityResource::collection($cities), 'Cities retrieved successfully');
    }

    /**
     * @param CreateCityAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/cities",
     *      summary="Store a newly created City in storage",

     */
    public function store(CreateCityAPIRequest $request)
    {
        $input = $request->all();

        $city = $this->cityRepository->create($input);

        return response()->json($city);
//        return $this->sendResponse(new CityResource($city), 'City saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/cities/{id}",
     *      summary="Display the specified City",
     */
    public function show($id)
    {
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            return $this->sendError('City not found');
        }

        return response()->json($city);
//        return $this->sendResponse(new CityResource($city), 'City retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCityAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/cities/{id}",
     *      summary="Update the specified City in storage",

     */
    public function update($id, UpdateCityAPIRequest $request)
    {
        $input = $request->all();

        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            return $this->sendError('City not found');
        }

        $city = $this->cityRepository->update($input, $id);

        return response()->json($city);
//        return $this->sendResponse(new CityResource($city), 'City updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/cities/{id}",
     *      summary="Remove the specified City from storage",

     */
    public function destroy($id)
    {
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            return $this->sendError('City not found');
        }

        $city->delete();


        return $this->sendSuccess('City deleted successfully');
    }
}
