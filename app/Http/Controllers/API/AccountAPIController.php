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
        if ($user){
            return $this->sendError('mail.already.taken',401);
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
     *      path="/accounts",

     */

    public function register(CreateAccountAPIRequest $request)
    {
        $input = $request->all();

        $input['activated'] = false;

        // create user
        $user = User::create([
            'name' => $input['user']['username'],
            'email' => $input['user']['email'],
            'password' => Hash::make($input['user']['password']),
            'logins' => 0,
            ]);

        $input['user_id'] = $user->id;

        $account = $this->accountRepository->create($input);

        //Send email

        return response()->json($account);
//        return $this->sendResponse($account->toArray(), 'Account saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/accounts/{id}",
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
//        return $this->sendResponse($account->toArray(), 'Account retrieved successfully');
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



    public function updateImage(Request $request)
    {

        $input = $request->all();

        $account = $this->accountRepository->find($input['account_id']);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        if ($request->hasFile('image'))
        {
            $date = time();
            $image      = $request->file('image');
            $filename  = $date .'_'. $image->getClientOriginalName() ;
            $extension = $image->getClientOriginalExtension();

            $path = $request->file('image')->storePubliclyAs(
                'images/accounts',
                $filename,
                'local');
            $account->image_url = url($path);

            $account = $this->accountRepository->update($account->toArray(), $account->id);
            return response()->json($account);
        } else {
            return response()->json($account,404);
        }
    }
}
