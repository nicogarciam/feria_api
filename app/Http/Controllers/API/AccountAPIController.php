<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateAccountAPIRequest;
use App\Http\Requests\API\UpdateAccountAPIRequest;
use App\Models\Account;
use App\Models\Entity;
use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Response;

/**
 * Class AccountController
 * @package App\Http\Controllers\API
 */

class AccountAPIController extends AppBaseController
{
    /** @var  AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepository = $accountRepo;
    }

    /**
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/accounts",
     *      summary="Get a listing of Accounts.",
     *      tags={"Account"},
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Account")
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $accounts = $this->accountRepository->allLike(
            $request->get('q'),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($accounts);
        //        return $this->sendResponse($accounts->toArray(), 'Accounts retrieved successfully');
    }


    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/accounts/like/{query}",
     *      summary="Search for Accounts by query",
     *      tags={"Account"},
     *      @SWG\Parameter(
     *          name="query",
     *          in="path",
     *          description="Search query",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Account")
     *          )
     *      )
     * )
     */
    public function like(Request $request)
    {

        $accounts = $this->accountRepository->allLike(
            $request->get('q'),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($accounts);
        //        return $this->sendResponse($accounts->toArray(), 'Accounts retrieved successfully');
    }


    public function validateEmail(Request $request)
    {

        $mail = $request->get('email');
        $user = User::firstWhere('email', $mail);
        if ($user) {
            return $this->sendError('mail.already.taken', 401);
        } else {
            return $this->sendResponse(true, 'mail.available');
        }

        //        return $this->sendResponse($accounts->toArray(), 'Accounts retrieved successfully');
    }



    /**
     * @param CreateAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/accounts",
     *      summary="Store a newly created Account in storage",
     *      tags={"Account"},
     *      @SWG\Response(
     *          response=201,
     *          description="Account created successfully",
     *          @SWG\Schema(ref="#/definitions/Account")
     *      )
     * )
     */
    public function store(CreateAccountAPIRequest $request)
    {
        $input = $request->all();

        $account = $this->accountRepository->create($input);

        return response()->json($account);
        //        return $this->sendResponse($account->toArray(), 'Account saved successfully');
    }


    /**
     * @param CreateAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/register",
     *      summary="Register a new user account",
     *      tags={"Account"},
     *      @SWG\Response(
     *          response=201,
     *          description="User registered successfully",
     *          @SWG\Schema(ref="#/definitions/Account")
     *      )
     * )
     */

    public function register(CreateAccountAPIRequest $request)
    {
        $input = $request->all();

        $input['activated'] = false;

        $userData = $input;
        $fullName = trim($userData['name'] ?? '');
        $nameParts = preg_split('/\s+/', $fullName, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        // create user
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'logins' => 0,
        ]);

        $input['user_id'] = $user->id;
        $input['first_name'] = $firstName;
        $input['last_name'] = $lastName;
        $input['email'] = $userData['email'];


        $account = $this->accountRepository->create($input);

        //Send email

        return response()->json($account);
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/accounts/{id}",
     *      tags={"Account"},
     *      description="Display the specified Account",
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Account",
     *          required=true,
     *          type="integer",
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="success", type="boolean"),
     *              @SWG\Property(property="data", ref="#/definitions/Account"),
     *              @SWG\Property(property="message", type="string")
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Account $account */
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }
        return response()->json($account);
    }


    public function myAccount(Request $request)
    {
        $user = $request->user();


        $account  = $this->accountRepository->findFullByUserId($user->id);

        return response()->json($account, 200);
    }



    public function account(Request $request)
    {
        // $request->user() returns an instance of the authenticated user...

        $user = $request->user();

        $account  = $user->account;
        $authorities = array();

        foreach ($user->authorities as $auth) {
            array_push($authorities, $auth->authority);
        }

        $user->authorities = $authorities;
        $account->entity;
        return response()->json($user, 200);
    }

    /**
     * @param int $id
     * @param UpdateAccountAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/accounts/{id}",
     *      tags={"Account"},
     *      summary="Update the specified Account in storage",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="Account id",
     *          required=true,
     *          type="integer"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Account updated successfully",
     *          @SWG\Schema(ref="#/definitions/Account")
     *      ),
     *      @SWG\Response(response=404, description="Account not found")
     * )
     */
    public function update($id, UpdateAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var Account $account */
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        $account = $this->accountRepository->update($input, $id);
        return response()->json($account);
        //        return $this->sendResponse($account->toArray(), 'Account updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/accounts/{id}",
     *      tags={"Account"},
     *      summary="Remove the specified Account from storage",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="Account id",
     *          required=true,
     *          type="integer"
     *      ),
     *      @SWG\Response(response=200, description="Account deleted successfully"),
     *      @SWG\Response(response=404, description="Account not found")
     * )
     */
    public function destroy($id)
    {
        /** @var Account $account */
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        $account->delete();

        return $this->sendSuccess('Account deleted successfully');
    }
}
