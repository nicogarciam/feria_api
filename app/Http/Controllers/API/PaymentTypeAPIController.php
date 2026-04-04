<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentTypeAPIRequest;
use App\Http\Requests\API\UpdatePaymentTypeAPIRequest;
use App\Models\PaymentType;
use App\Repositories\PaymentTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PaymentTypeResource;
use Response;

/**
 * Class PaymentTypeController
 * @package App\Http\Controllers\API
 */

class PaymentTypeAPIController extends AppBaseController
{
