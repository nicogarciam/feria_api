<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentAPIRequest;
use App\Http\Requests\API\UpdatePaymentAPIRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Services\MovementsService;
use App\Services\SaleService;
use Facades\App\Services\DataAccessValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PaymentResource;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */

class PaymentAPIController extends AppBaseController
{
