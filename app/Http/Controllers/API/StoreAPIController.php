<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreAPIRequest;
use App\Http\Requests\API\UpdateStoreAPIRequest;
use App\Models\CashAccount;
use App\Models\Store;
use App\Repositories\ProductRepository;
use App\Repositories\StoreRepository;
use App\Services\ImageService;
use Facades\App\Services\DataAccessValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class storeController
 * @package App\Http\Controllers\API
 */

class StoreAPIController extends AppBaseController
{
    /** @var  StoreRepository */
    private $storeRepository;
    private $productRepository;
    private $imageService;

    public function __construct(StoreRepository   $storeRepo,
                                ProductRepository $productRepository,
                                ImageService $imageService)
    {
        $this->storeRepository = $storeRepo;
        $this->productRepository = $productRepository;
        $this->imageService = $imageService;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/stores",
     *      summary="Get list of Stores",
     *      tags={"Store"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Store")
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $stores = $this->storeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($stores);
//        return $this->sendResponse(StoreResource::collection($stores), 'stores retrieved successfully');
    }



    /**
     * @param CreateStoreAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/stores",
     *      summary="Store a newly created Store in storage",
     *      tags={"Store"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(ref="#/definitions/Store")
     *      )
     * )
     */
    public function store(CreateStoreAPIRequest $request)
    {
        $input = $request->all();
        $input['city_id'] = $input['city_id'] ?? 1;
        $logoPath = $input['logo'] ?? null;
        $user = Auth::user();

        $store = $this->storeRepository->create($input);
        if (!empty($logoPath)) {
            $movedLogoPath = $this->imageService->moveFromGenericToStore($logoPath, $store, 'stores');
            if ($movedLogoPath !== null) {
                $store = $this->storeRepository->update(['logo' => $movedLogoPath], $store->id);
            }
        }

        $store->users()->attach($user->id, [
            'role' => 'owner',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        CashAccount::create([
            'name' => 'Caja Principal',
            'store_id' => $store->id,
            'is_default' => true,
            'balance' => 0
        ]);

        $stores = auth()->user()->myStores();
        session()->put('stores', $stores);

        return response()->json($store);
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/stores/{id}",
     *      summary="Display the specified Store",
     *      tags={"Store"},
     *      description="Get Store by id",
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Store",
     *          required=true,
     *          type="integer",
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
     *                  ref="#/definitions/Store"
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

        $valid = DataAccessValidation::validateStore($id);

        if (!$valid) {
            return $this->sendError('unauthorized','403');
        }
        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }
        return response()->json($store);
    }


    /**
     * @param int $id
     * @param UpdatestoreAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/stores/{id}",
     *      summary="Update the specified Store in storage",
     *      tags={"Store"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Store",
     *          required=true,
     *          type="integer",
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(ref="#/definitions/Store")
     *      )
     * )
     */
    public function update($id, UpdateStoreAPIRequest $request)
    {

        $valid = DataAccessValidation::validateStore($id);

        if (!$valid) {
            return $this->sendError('unauthorized','403');
        }

        $input = $request->all();

        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        $store = $this->storeRepository->update($input, $id);

        return response()->json($store);
//        return $this->sendResponse(new StoreResource($store), 'Store updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/stores/{id}",
     *      summary="Remove the specified Store from storage",
     *      tags={"Store"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Store",
     *          required=true,
     *          type="integer",
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *      )
     * )
     */
    public function destroy($id)
    {
        $valid = DataAccessValidation::validateStore($id);

        if (!$valid) {
            return $this->sendError('unauthorized.store','403');
        }
        /** @var Store $store */
        $store = $this->storeRepository->find($id);



        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        $store->delete();

        return $this->sendSuccess('Store deleted successfully');
    }


    public function myStores()
    {
        $user = Auth::user();
        $myStores = $user->myStores();
        session()->put('stores', $myStores);

        if (empty($myStores)) {
            return $this->sendError('Entity not found');
        }

        return response()->json($myStores);
    }

    public function selectStore($id)
    {
        $valid = DataAccessValidation::validateStore($id);

        if (!$valid) {
            return $this->sendError('unauthorized.store', '403');
        }

        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        $user = Auth::user();
        if ($user->role === 'SUPER_ADMIN') {
            $role = 'SUPER_ADMIN';
        } else {
            $role = DB::table('user_store')
                ->where('user_id', $user->id)
                ->where('store_id', $id)
                ->value('role') ?? $user->role;
        }

        session(['store_id' => $id]);

        return $this->sendResponse([
            'store' => $store,
            'role' => $role
        ], 'Store retrieved successfully');
    }

    public function cashAccounts($id)
    {
        $valid = DataAccessValidation::validateStore($id);
        if (!$valid) {
            return $this->sendError('unauthorized.store', '403');
        }
        $store = $this->storeRepository->find($id);
        if (empty($store)) {
            return $this->sendError('Store not found');
        }
        return response()->json($store->cashAccounts);
    }


    public function updateLogo(Request $request)
    {

        $input = $request->all();

        $store = $this->storeRepository->find($input['store_id']);

        if (empty($store)) {
            return $this->sendError('Entity not found');
        }

        if ($request->hasFile('logo'))
        {
            $logo      = $request->file('logo');
            $filename  = $logo->getClientOriginalName() . '_' . $store->id;
            $extension = $logo->getClientOriginalExtension();
            $uploadPath = "public/images/logos";

            $path = $request->file('logo')->storePubliclyAs(
                'images/logos',
                $store->id.'_'. $store->name .'_logo'.'.'.$extension,
                'local');
            $store->logo = url($path);

            $store = $this->storeRepository->update($store->toArray(), $store->id);
            $store->city();
            return response()->json($store);
        } else {
            return response()->json($store,404);
        }
    }


}

