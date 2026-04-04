<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMovementAPIRequest;
use App\Http\Requests\API\UpdateMovementAPIRequest;
use App\Models\Balance;
use App\Models\Movement;
use App\Repositories\MovementRepository;
use Facades\App\Services\DataAccessValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MovementResource;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class MovementController
 * @package App\Http\Controllers\API
 */

class MovementAPIController extends AppBaseController
{
