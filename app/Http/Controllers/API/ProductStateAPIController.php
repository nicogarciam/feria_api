<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductAPIRequest;
use App\Http\Requests\API\UpdateProductAPIRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Repositories\ProductRepository;
use App\Repositories\ProductStateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class AccommodationController
 * @package App\Http\Controllers\API
 */

class ProductStateAPIController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productStateRepository;

    public function __construct(ProductStateRepository $productSateRepo)
    {
        $this->productStateRepository = $productSateRepo;
    }


    public function index(Request $request)
    {
        $states = $this->productStateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return response()->json($states);

        //return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }



    public function store(Request $request)
    {
        $input = $request->all();

        $input['state_id'] = 1;

        $product = $this->productStateRepository->create($input);

        return response()->json($product);
    }

    public function show($id)
    {
        /** @var Product $product */
        $product = $this->productStateRepository->find($id, ['category','store']);

        if (empty($product)) {
            return $this->sendError('ProductSatate not found');
        }

        return response()->json($product);
    }


    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Product $product */
        $product = $this->productStateRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product State not found');
        }

        $product = $this->productStateRepository->update($input, $id);

        return response()->json($product);
    }


    public function destroy($id)
    {
        $product = $this->productStateRepository->find($id);

        if (empty($product)) {
            return $this->sendError('ProductState not found');
        }

        $product->delete();

        return $this->sendSuccess('ProductState deleted successfully');
    }
}
