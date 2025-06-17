<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductAPIRequest;
use App\Http\Requests\API\UpdateProductAPIRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class AccommodationController
 * @package App\Http\Controllers\API
 */

class ProductAPIController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }


    public function index(Request $request)
    {

        $search = $request->except(['skip', 'limit', 'per_page', 'states_selected','like']);
        $states_ids = $request->get('states_selected') ? explode(',',$request->get('states_selected')) : null;
        $search['state_id'] = $states_ids;
        $page = $this->productRepository->allFullPaginate(
            $search,
            ['category','store','state','provider'],
            $request->get('skip'),
            $request->get('limit'),
            $request->get('per_page'),
            $request->get('search')
        );

        return response()->json($page);
    }



//  Retorna los Productos del Sale
    public function findForSale($saleId = null, $type = 'SIMPL')
    {

        $products = $this->productRepository->forSaleFull($saleId);

        return response()->json($products);
    }


    public function store(CreateProductAPIRequest $request)
    {
        $input = $request->all();

        $input['state_id'] = 1;

        $product = $this->productRepository->create($input);

        return response()->json($product);
    }

    public function show($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id, ['category','store','provider']);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        return response()->json($product);
    }


    public function update($id, UpdateProductAPIRequest $request)
    {
        $input = $request->all();

        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product = $this->productRepository->update($input, $id);

        return response()->json($product);
    }


    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendSuccess('Product deleted successfully');
    }
}
