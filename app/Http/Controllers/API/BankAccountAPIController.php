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
    /** @var  BankAccountRepository */
    private $bankAccountRepository;

    public function __construct(BankAccountRepository $bankAccountRepo)
    {
        $this->bankAccountRepository = $bankAccountRepo;
    }


    public function index(Request $request)
    {
        $bankAccounts = $this->bankAccountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($bankAccounts);

//        return $this->sendResponse(BankAccountResource::collection($bankAccounts), 'Bank Accounts retrieved successfully');
    }


    public function store(CreateBankAccountAPIRequest $request)
    {
        $input = $request->all();

        $bankAccount = $this->bankAccountRepository->create($input);

        return response()->json($bankAccount);
    }

    public function show($id)
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($id);

        if (empty($bankAccount)) {
            return $this->sendError('Bank Account not found');
        }

        return response()->json($bankAccount);
    }


    public function update($id, UpdateBankAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($id);

        if (empty($bankAccount)) {
            return $this->sendError('Bank Account not found');
        }

        $bankAccount = $this->bankAccountRepository->update($input, $id);

        return response()->json($bankAccount);
    }


    public function destroy($id)
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($id);

        if (empty($bankAccount)) {
            return $this->sendError('Bank Account not found');
        }

        $bankAccount->delete();

        return $this->sendSuccess('Bank Account deleted successfully');
    }
}
