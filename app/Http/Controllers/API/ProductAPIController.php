<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductAPIRequest;
use App\Http\Requests\API\UpdateProductAPIRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\Sale;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Response;
use Facades\App\Services\DataAccessValidation;

/**
 * Class ProductAPIController
 * @package App\Http\Controllers\API
 * @SWG\Definition(
 *   definition="Product",
 *   type="object",
 *   @SWG\Xml(name="Product"),
 *   @SWG\Property(property="id", type="integer", description="Product ID", readOnly=true),
 *   @SWG\Property(property="code", type="string", description="Product code"),
 *   @SWG\Property(property="title", type="string", description="Product title"),
 *   @SWG\Property(property="description", type="string", description="Product description"),
 *   @SWG\Property(property="store_id", type="integer", description="Store ID"),
 *   @SWG\Property(property="provider_id", type="integer", description="Provider ID"),
 *   @SWG\Property(property="category_id", type="integer", description="Category ID"),
 *   @SWG\Property(property="state_id", type="integer", description="Product state ID"),
 *   @SWG\Property(property="color", type="string", description="Product color"),
 *   @SWG\Property(property="size", type="string", description="Product size"),
 *   @SWG\Property(property="price", type="number", format="float", description="Product price"),
 *   @SWG\Property(property="cost", type="number", format="float", description="Product cost"),
 *   @SWG\Property(property="fee", type="number", format="float", description="Product fee"),
 *   @SWG\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *   @SWG\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 *
 * @SWG\Definition(
 *   definition="ProductRequest",
 *   type="object",
 *   @SWG\Xml(name="ProductRequest"),
 *   required={"code", "store_id"},
 *   @SWG\Property(property="code", type="string", description="Product code"),
 *   @SWG\Property(property="title", type="string", description="Product title"),
 *   @SWG\Property(property="description", type="string", description="Product description"),
 *   @SWG\Property(property="store_id", type="integer", description="Store ID"),
 *   @SWG\Property(property="provider_id", type="integer", description="Provider ID"),
 *   @SWG\Property(property="category_id", type="integer", description="Category ID"),
 *   @SWG\Property(property="state_id", type="integer", description="Product state ID"),
 *   @SWG\Property(property="color", type="string", description="Product color"),
 *   @SWG\Property(property="size", type="string", description="Product size"),
 *   @SWG\Property(property="price", type="number", format="float", description="Product price"),
 *   @SWG\Property(property="cost", type="number", format="float", description="Product cost"),
 *   @SWG\Property(property="fee", type="number", format="float", description="Product fee")
 * )
 */
class ProductAPIController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/products",
     *      summary="Get a listing of all Products",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
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
     *              @SWG\Items(ref="#/definitions/Product")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        //return response()->json($products);
        return $this->sendResponse($products, 'Products retrieved successfully');
    }

    public function query(Request $request)
     {
        //($search = [], $skip = null, $limit = null, $withs = [], $sorts = [], $like = null)
        $products = $this->productRepository->allQueryFull
        (
            $request->except(['skip', 'limit','like','withs','sorts']),
            $request->get('skip'),
            $request->get('limit'),
            [],
            [],
            $request->get('like')

        );

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }


    /**
     * Store a newly created Product.
     *
     * @param CreateProductAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/products",
     *      summary="Store a newly created Product",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="Product data",
     *          @SWG\Schema(ref="#/definitions/ProductRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Product created successfully",
     *          @SWG\Schema(ref="#/definitions/Product")
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Bad request"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function store(CreateProductAPIRequest $request)
    {
        $input = $request->all();
        $input['code'] = $input['code'] ?? strtoupper(substr(uniqid(), 0, 10)) ;

        $product = $this->productRepository->create($input);

        return $this->sendResponse(new ProductResource($product), 'Product created successfully');
    }

    /**
     * Display the specified Product.
     *
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/products/{id}",
     *      summary="Display the specified Product",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Product ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(ref="#/definitions/Product")
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id, ['images']);
        // $product = $this->productRepository->full($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        return response()->json($product);
    }

    /**
     * Update the specified Product.
     *
     * @param int $id
     * @param UpdateProductAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/products/{id}",
     *      summary="Update the specified Product",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Product ID"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="Product data",
     *          @SWG\Schema(ref="#/definitions/ProductRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Product updated successfully",
     *          @SWG\Schema(ref="#/definitions/Product")
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function update($id, UpdateProductAPIRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $input = $request->all();
        $newProductImages = $request->file('images');
        $product = $this->productRepository->update($input, $id);

        /**
        * $productImages = Image::where('product_id', $id)->get();
        * $productImages->each(function ($image) use ($newProductImages) {
            * if (!$newProductImages->contains($image->id)) {
                * $filePath = str_replace('storage/', '', $image->src);
                * // Eliminar el archivo físico
                * if (Storage::disk('public')->exists($filePath)) {
                    * Storage::disk('public')->delete($filePath);
                * }
                * $image->delete();
            * }
        * });
 *
* Image::whereIn('product_id', $newProductImages)->update(['product_id' => $id]);
         */
        return response()->json($product);
       // return $this->sendResponse(new ProductResource($product), 'Product updated successfully');
    }

    /**
     * Remove the specified Product.
     *
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/products/{id}",
     *      summary="Remove the specified Product",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Product ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Product deleted successfully"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendResponse($id, 'Product deleted successfully');
    }

    /**
     * Find products for a specific store.
     *
     * @param int $storeId
     * @param string|null $type
     * @return Response
     *
     * @SWG\Get(
     *      path="/store/{storeId}/products/{type}",
     *      summary="Find products for a specific store",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="storeId",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Store ID"
     *      ),
     *      @SWG\Parameter(
     *          name="type",
     *          in="path",
     *          type="string",
     *          required=false,
     *          description="Product type filter"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Product")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=403,
     *          description="Unauthorized store access"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function findByStore($storeId, $type = null)
    {
        $valid = DataAccessValidation::validateStore($storeId);

        if (!$valid) {
            return $this->sendError('unauthorized.store', '403');
        }

        $products = $this->productRepository->findByStore($storeId, $type);

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }

    /**
     * Find products for a specific sale.
     *
     * @param int $saleId
     * @return Response
     *
     * @SWG\Get(
     *      path="/sales/{saleId}/products",
     *      summary="Find products for a specific sale",
     *      tags={"Product"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="saleId",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Sale ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Product")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Sale not found"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function findForSale($saleId)
    {
        $sale = Sale::with('products')->find($saleId);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        return $this->sendResponse(ProductResource::collection($sale->products), 'Products retrieved successfully');
    }
}
