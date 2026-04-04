<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBankAccountAPIRequest;
use App\Http\Requests\API\UpdateBankAccountAPIRequest;
use App\Models\BankAccount;
use App\Repositories\BankAccountRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\BankAccountResource;
use Response;

/**
 * Class BankAccountController
 * @package App\Http\Controllers\API
 */

class BankAccountAPIController extends AppBaseController
{
