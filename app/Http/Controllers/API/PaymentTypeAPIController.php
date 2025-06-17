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
    /** @var  PaymentTypeRepository */
    private $paymentTypeRepository;

    public function __construct(PaymentTypeRepository $paymentTypeRepo)
    {
        $this->paymentTypeRepository = $paymentTypeRepo;
    }


    public function index(Request $request)
    {
        $paymentTypes = $this->paymentTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PaymentTypeResource::collection($paymentTypes), 'Payment Types retrieved successfully');
    }


    public function store(CreatePaymentTypeAPIRequest $request)
    {
        $input = $request->all();

        $paymentType = $this->paymentTypeRepository->create($input);

        return $this->sendResponse(new PaymentTypeResource($paymentType), 'Payment Type saved successfully');
    }


    public function show($id)
    {
        /** @var PaymentType $paymentType */
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            return $this->sendError('Payment Type not found');
        }

        return $this->sendResponse(new PaymentTypeResource($paymentType), 'Payment Type retrieved successfully');
    }


    public function update($id, UpdatePaymentTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var PaymentType $paymentType */
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            return $this->sendError('Payment Type not found');
        }

        $paymentType = $this->paymentTypeRepository->update($input, $id);

        return $this->sendResponse(new PaymentTypeResource($paymentType), 'PaymentType updated successfully');
    }


    public function destroy($id)
    {
        /** @var PaymentType $paymentType */
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            return $this->sendError('Payment Type not found');
        }

        $paymentType->delete();

        return $this->sendSuccess('Payment Type deleted successfully');
    }
}
