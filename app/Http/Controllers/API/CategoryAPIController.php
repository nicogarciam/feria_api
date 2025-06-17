<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAccommodationTypeAPIRequest;
use App\Http\Requests\API\UpdateAccommodationTypeAPIRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class AccommodationTypeController
 * @package App\Http\Controllers\API
 */

class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $accommodationTypeRepo)
    {
        $this->categoryRepository = $accommodationTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/accommodationTypes",
     *      summary="Get a listing of the AccommodationTypes.",

     */
    public function index(Request $request)
    {
        $accommodationTypes = $this->categoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($accommodationTypes);
//        return $this->sendResponse(CategoryResource::collection($accommodationTypes), 'Accommodation Types retrieved successfully');
    }


    public function findByHotel($hotelId = null)
    {

//        if ($hotelId == null){
//            $entity = Auth::user()->myEntity();
//
//            if ($entity )
//                $entityId = $entity->id;
//        }

        $accommodationTypes = $this->categoryRepository->all(['hotel_id' => $hotelId]);

        return response()->json($accommodationTypes);
    }

    /**
     * @param CreateAccommodationTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/accommodationTypes",

     */
    public function store(CreateAccommodationTypeAPIRequest $request)
    {
        $input = $request->all();
        $accommodationType = $this->categoryRepository->create($input);

        return response()->json($accommodationType);
//        return $this->sendResponse(new CategoryResource($accommodationType), 'Accommodation Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/accommodationTypes/{id}",
     *      summary="Display the specified Category",
     * )
     */
    public function show($id)
    {
        /** @var Category $accommodationType */
        $accommodationType = $this->categoryRepository->find($id);

        if (empty($accommodationType)) {
            return $this->sendError('Accommodation Type not found');
        }

        return response()->json($accommodationType);
//        return $this->sendResponse(new CategoryResource($accommodationType), 'Accommodation Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAccommodationTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/accommodationTypes/{id}",
     *      summary="Update the specified Category in storage",

     */
    public function update($id, UpdateAccommodationTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Category $accommodationType */
        $accommodationType = $this->categoryRepository->find($id);

        if (empty($accommodationType)) {
            return $this->sendError('Accommodation Type not found');
        }

        $accommodationType = $this->categoryRepository->update($input, $id);

        return response()->json($accommodationType);
//        return $this->sendResponse(new CategoryResource($accommodationType), 'Category updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/accommodationTypes/{id}",
     *      summary="Remove the specified Category from storage",

     * )
     */
    public function destroy($id)
    {
        /** @var Category $accommodationType */
        $accommodationType = $this->categoryRepository->find($id);

        if (empty($accommodationType)) {
            return $this->sendError('Accommodation Type not found');
        }

        $accommodationType->delete();

        return $this->sendSuccess('Accommodation Type deleted successfully');
    }
}
