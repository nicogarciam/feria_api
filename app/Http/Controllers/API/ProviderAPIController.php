<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProviderAPIRequest;
use App\Http\Requests\API\UpdateProviderAPIRequest;
use App\Repositories\ProviderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProviderAPIController
 * @package App\Http\Controllers\API
 * @SWG\Definition(
 *   definition="Provider",
 *   type="object",
 *   @SWG\Xml(name="Provider"),
 *   @SWG\Property(property="id", type="integer", description="Provider ID", readOnly=true),
 *   @SWG\Property(property="name", type="string", description="Provider name"),
 *   @SWG\Property(property="cuil", type="string", description="Provider CUIL"),
 *   @SWG\Property(property="contact_name", type="string", description="Contact name"),
 *   @SWG\Property(property="email", type="string", description="Provider email"),
 *   @SWG\Property(property="address", type="string", description="Provider address"),
 *   @SWG\Property(property="token", type="string", description="Provider token"),
 *   @SWG\Property(property="password", type="string", description="Provider password"),
 *   @SWG\Property(property="city_id", type="integer", description="City ID"),
 *   @SWG\Property(property="phone", type="string", description="Provider phone"),
 *   @SWG\Property(property="fee", type="integer", description="Provider fee"),
 *   @SWG\Property(property="alias", type="string", description="Provider alias"),
 *   @SWG\Property(property="bank", type="string", description="Provider bank"),
 *   @SWG\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *   @SWG\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 *
 * @SWG\Definition(
 *   definition="ProviderRequest",
 *   type="object",
 *   @SWG\Xml(name="ProviderRequest"),
 *   required={"name", "email"},
 *   @SWG\Property(property="name", type="string", description="Provider name"),
 *   @SWG\Property(property="cuil", type="string", description="Provider CUIL"),
 *   @SWG\Property(property="contact_name", type="string", description="Contact name"),
 *   @SWG\Property(property="email", type="string", description="Provider email"),
 *   @SWG\Property(property="address", type="string", description="Provider address"),
 *   @SWG\Property(property="token", type="string", description="Provider token"),
 *   @SWG\Property(property="password", type="string", description="Provider password"),
 *   @SWG\Property(property="city_id", type="integer", description="City ID"),
 *   @SWG\Property(property="phone", type="string", description="Provider phone"),
 *   @SWG\Property(property="fee", type="integer", description="Provider fee"),
 *   @SWG\Property(property="alias", type="string", description="Provider alias"),
 *   @SWG\Property(property="bank", type="string", description="Provider bank")
 * )
 */

class ProviderAPIController extends AppBaseController
{
    private $providerRepository;

    public function __construct(ProviderRepository $providerRepo)
    {
        $this->providerRepository = $providerRepo;
    }

    /**
     * Display a listing of the Provider.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/providers",
     *      summary="Get a listing of all Providers",
     *      tags={"Provider"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="q",
     *          in="query",
     *          type="string",
     *          description="Search query"
     *      ),
     *      @SWG\Parameter(
     *          name="skip",
     *          in="query",
     *          type="integer",
     *          description="Number of records to skip"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          in="query",
     *          type="integer",
     *          description="Number of records to return"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Provider")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
     */
    public function index(Request $request)
    {

        $q = $request->get('q');

        if ($q) {
            $providers = $this->providerRepository->allLike(
                $q,
                $request->get('skip'),
                10
            );

        } else {
            $providers = $this->providerRepository->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }
        return response()->json($providers);

    }


    /**
     * Store a newly created Provider in storage.
     *
     * @param CreateProviderAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/providers",
     *      summary="Store a newly created Provider in storage",
     *      tags={"Provider"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Provider that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProviderRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              ref="#/definitions/Provider"
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
     */
    public function store(CreateProviderAPIRequest $request)
    {
        $input = $request->all();
//        $user = Auth::user();
//        $entityId = $user->myEntity()->id;
//        $input['entity_id'] = $entityId;

        $provider = $this->providerRepository->create($input);

        return response()->json($provider);
    }


    /**
     * Display the specified Provider.
     *
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/providers/{id}",
     *      summary="Display the specified Provider",
     *      tags={"Provider"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Provider",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              ref="#/definitions/Provider"
     *          )
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Provider not found"
     *      )
     * )
     */
    public function show($id)
    {
        $provider = $this->providerRepository->find($id);

        if (empty($provider)) {
            return $this->sendError('Provider not found');
        }

        return response()->json($provider);

    }


    /**
     * Update the specified Provider in storage.
     *
     * @param int $id
     * @param UpdateProviderAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Put(
     *      path="/providers/{id}",
     *      summary="Update the specified Provider in storage",
     *      tags={"Provider"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Provider",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Provider that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProviderRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              ref="#/definitions/Provider"
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Bad request"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Provider not found"
     *      )
     * )
     */
    public function update($id, UpdateProviderAPIRequest $request)
    {
        $input = $request->all();

        $provider = $this->providerRepository->find($id);

        if (empty($provider)) {
            return $this->sendError('Instructor not found');
        }

        $provider = $this->providerRepository->update($input, $id);

        return response()->json($provider);
    }


    /**
     * Remove the specified Provider from storage.
     *
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Delete(
     *      path="/providers/{id}",
     *      summary="Remove the specified Provider from storage",
     *      tags={"Provider"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Provider",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
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
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Provider not found"
     *      )
     * )
     */
    public function destroy($id)
    {
        $provider = $this->providerRepository->find($id);

        if (empty($provider)) {
            return $this->sendError('Provider not found');
        }

        $provider->delete();

        return $this->sendSuccess('Provider deleted successfully');
    }
}
