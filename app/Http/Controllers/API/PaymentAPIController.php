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
use App\Services\PaginationService;
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

        $page = $request->get('page', 1);
        $size = $request->get('size', 10);
        $sort = $request->get('sort', 'date,desc');
        $where = $request->except(['page', 'size', 'sort', 'q']);

        if (!DataAccessValidation::validateStore(isset($input['store_id']) ?: null)) {
            return $this->sendError('unauthorized.store','403');
        }


        $query = $this->paymentRepository->allLikeQuery($request->get('q'), $where, $request->customer_id);
        // return response()->json($query);
        return PaginationService::forAngular($query, $request);
    }

    public function findForSale($saleId = null)
    {

        $payments = $this->paymentRepository->forSaleFull($saleId);

        return response()->json($payments);

    }

    public function store(CreatePaymentAPIRequest $request)
    {
        $input = $request->all();

        $input['user'] = auth()->user()->email;
        $input['payment_state_id'] = $input['payment_state_id'] ?? 1;
        $payment = $this->paymentRepository->create($input);

        MovementsService::generatePayCredit($payment);
        SaleService::checkSaleState($payment, 'new.payment');

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

    public function destroy($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        try {
            DB::beginTransaction();

            $payment->delete();
            DB::table('movements')->where('pay_id','=',$id)->delete();
            SaleService::checkSaleState($payment, "delete.payment");

            DB::commit();
            return $this->sendSuccess('Payment deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error al eliminar el pago: ' . $e->getMessage());
        }
    }
}
