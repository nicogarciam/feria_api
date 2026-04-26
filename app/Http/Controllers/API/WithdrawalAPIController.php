<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWithdrawalAPIRequest;
use App\Http\Requests\API\UpdateWithdrawalAPIRequest;
use App\Models\Withdrawal;
use App\Models\Movement;
use App\Repositories\WithdrawalRepository;
use App\Services\MovementsService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class WithdrawalAPIController extends AppBaseController
{
    /** @var  WithdrawalRepository */
    private $withdrawalRepository;

    public function __construct(WithdrawalRepository $withdrawalRepo)
    {
        $this->withdrawalRepository = $withdrawalRepo;
    }

    public function index(Request $request)
    {
        $withdrawals = $this->withdrawalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($withdrawals);
    }

    public function store(CreateWithdrawalAPIRequest $request)
    {
        $input = $request->all();
        $input['user'] = Auth::user()->email;

        try {
            DB::beginTransaction();
            $withdrawal = $this->withdrawalRepository->create($input);
            MovementsService::generateWithdrawalMovement($withdrawal);
            DB::commit();

            return response()->json($withdrawal);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error creating withdrawal: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $withdrawal = $this->withdrawalRepository->find($id);

        if (empty($withdrawal)) {
            return $this->sendError('Withdrawal not found');
        }

        return response()->json($withdrawal);
    }

    public function update($id, UpdateWithdrawalAPIRequest $request)
    {
        $input = $request->all();
        $withdrawal = $this->withdrawalRepository->find($id);

        if (empty($withdrawal)) {
            return $this->sendError('Withdrawal not found');
        }

        try {
            DB::beginTransaction();
            $withdrawal = $this->withdrawalRepository->update($input, $id);
            MovementsService::generateWithdrawalMovement($withdrawal);
            DB::commit();

            return response()->json($withdrawal);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error updating withdrawal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $withdrawal = $this->withdrawalRepository->find($id);

        if (empty($withdrawal)) {
            return $this->sendError('Withdrawal not found');
        }

        try {
            DB::beginTransaction();
            $withdrawal->delete();
            DB::table('movements')->where('withdrawal_id', $id)->delete();
            DB::commit();

            return $this->sendSuccess('Withdrawal deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error deleting withdrawal: ' . $e->getMessage());
        }
    }
}
