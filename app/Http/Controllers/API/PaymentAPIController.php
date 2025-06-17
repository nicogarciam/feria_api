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
    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->paymentRepository = $paymentRepo;
    }


    public function index(Request $request)
    {

        $input = $request->all();

        if (!DataAccessValidation::validateStore(isset($input['store_id']) ?: null)) {
            return $this->sendError('unauthorized.store','403');
        }

        $payments = $this->paymentRepository->allLike(
            $request->get('search'),
            $request->get('skip'),
            $request->get('limit'),
            $request->except(['skip', 'limit', 'customer_id']),
            $request->get('customer_id'),
        );
        return response()->json($payments);
    }

    public function store(CreatePaymentAPIRequest $request)
    {
        $input = $request->all();

        $payment = $this->paymentRepository->create($input);

        MovementsService::generatePayCredit($payment);
        SaleService::checkSaleState($payment);

        return response()->json($payment);
    }

    public function show($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        return response()->json($payment);
        return $this->sendResponse(new PaymentResource($payment), 'Payment retrieved successfully');
    }


    public function update($id, UpdatePaymentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment = $this->paymentRepository->update($input, $id);

        return response()->json($payment);

//        return $this->sendResponse(new PaymentResource($payment), 'Payment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/payments/{id}",
     *      summary="Remove the specified Payment from storage",
     *      tags={"Payment"},
     *      description="Delete Payment",
     */
    public function destroy($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment->delete();
        DB::table('movements')->where('pay_id','=',id)->delete();

        return $this->sendSuccess('Payment deleted successfully');
    }
}
