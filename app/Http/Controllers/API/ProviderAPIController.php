<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProviderAPIRequest;
use App\Http\Requests\API\UpdateProviderAPIRequest;
use App\Repositories\ProviderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class InstructorController
 * @package App\Http\Controllers\API
 */

class ProviderAPIController extends AppBaseController
{
    private $providerRepository;

    public function __construct(ProviderRepository $providerRepo)
    {
        $this->providerRepository = $providerRepo;
    }

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


    public function store(CreateProviderAPIRequest $request)
    {
        $input = $request->all();
//        $user = Auth::user();
//        $entityId = $user->myEntity()->id;
//        $input['entity_id'] = $entityId;

        $provider = $this->providerRepository->create($input);

        return response()->json($provider);
    }


    public function show($id)
    {
        $provider = $this->providerRepository->find($id);

        if (empty($provider)) {
            return $this->sendError('Provider not found');
        }

        return response()->json($provider);

    }


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


    public function destroy($id)
    {
        $provider = $this->providerRepository->find($id);

        if (empty($instructor)) {
            return $this->sendError('Provider not found');
        }

        $provider->delete();

        return $this->sendSuccess('Provider deleted successfully');
    }
}
