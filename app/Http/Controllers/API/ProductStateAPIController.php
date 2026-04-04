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
