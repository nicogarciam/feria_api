<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerAPIRequest;
use App\Http\Requests\API\UpdateCustomerAPIRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CustomerResource;
use Response;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API
 */

class CustomerAPIController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/customers",
     *      summary="Get a listing of the Customers.",
     *      tags={"Customer"},
     *      description="Get all Customers",
     *      produces={"application/json"},
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function index(Request $request)
    {
//        $customers = $this->customerRepository->all(
//            $request->except(['skip', 'limit']),
//            $request->get('skip'),
//            $request->get('limit')
//        );

        $customers = [];
        $q = $request->get('q');

        if ($q) {
            $customers = $this->customerRepository->allLike(
                $q,
                $request->get('skip'),
                10
            );

        } else {
            $customers = $this->customerRepository->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }
        return response()->json($customers);
//        return $this->sendResponse(CustomerResource::collection($customers), 'Customers retrieved successfully');
    }

    /**
     * @param CreateCustomerAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/customers",
     *      summary="Store a newly created Customer in storage",
     *      tags={"Customer"},
     *      description="Store Customer",
     *      produces={"application/json"},
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function store(CreateCustomerAPIRequest $request)
    {
        $input = $request->all();

        $customer = $this->customerRepository->create($input);

        return response()->json($customer);
//        return $this->sendResponse(new CustomerResource($customer), 'Customer saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/customers/{id}",
     *      summary="Display the specified Customer",
     *      tags={"Customer"},
     *      description="Get Customer",
     *      produces={"application/json"},
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function show($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        return response()->json($customer);
//        return $this->sendResponse(new CustomerResource($customer), 'Customer retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCustomerAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/customers/{id}",
     *      summary="Update the specified Customer in storage",
     *      tags={"Customer"},
     *      description="Update Customer",
     *      produces={"application/json"},
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function update($id, UpdateCustomerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer = $this->customerRepository->update($input, $id);

        return response()->json($customer);
//        return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/customers/{id}",
     *      summary="Remove the specified Customer from storage",
     *      tags={"Customer"},
     *      description="Delete Customer",
     *      produces={"application/json"},
          *      @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
* )
     */
    public function destroy($id)
    {
