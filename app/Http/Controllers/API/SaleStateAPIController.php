<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleAPIRequest;
use App\Repositories\SaleStateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\BookingStateResource;
use Response;

/**
 * Class BookingStateController
 * @package App\Http\Controllers\API
 */

class SaleStateAPIController extends AppBaseController
{
