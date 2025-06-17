<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\AccountRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Util\Json;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    private $accountRepository;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepository = $accountRepo;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'bad.credentials'], 401);
        }

        $user = auth()->user();
        $hotels = $user->myStores();
        session()->put('hotels', $hotels);

        $user->logins += 1;
        $user->account();
        $user->save();
        return $this->respondWithToken($token);
    }


    private function decodeGoogleCredential($jwt) {
        list($header, $payload, $signature) = explode(".", $jwt);

        $plainHeader = base64_decode($header);

        $plainPayload = base64_decode($payload);


        $decoded = [
            'header' => json_decode($plainHeader),
            'payload' => json_decode($plainPayload)
        ];

        return $decoded;

    }

    public function googleSignin()
    {

        $input = request()->all();
        $jwt = $input['credential'];

        $decoded = $this->decodeGoogleCredential($jwt);

        $payload = $decoded['payload'];


        if (empty($payload)) {
            return response()->json(['error' => 'Bad Credentials'], 403);
        }

        $user = new User();
        $user->name = $payload->name;
        $user->email = $payload->email;
        $user->google_id = $payload->sub;
        $user->picture = $payload->picture;

        try {
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                $account = [
                    'first_name' => $payload->given_name,
                    'last_name' => $payload->family_name,
                    'email' => $user->email,
                    'image_url' => $user->picture
                ];
                Account::where('user_id', $finduser->id)->update($account);
                $token = auth()->login($finduser);

            } else {
                $user->password = encrypt($user->google_id);
                $user->save();
                $newAccount = [
                    'first_name' => $payload->given_name,
                    'last_name' => $payload->family_name,
                    'email' => $user->email,
                    'image_url' => $user->picture,
                    'user_id' => $user->id
                ];
                $this->accountRepository->create($newAccount);
                $token = auth()->login($user);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        $user = auth()->user();

        $hotels = $user->myStores();
        session()->put('hotels', $hotels);

        $user->logins += 1;
        $user->google_id = $payload->sub;
        $user->account();
        $user->save();
        return $this->respondWithToken($token);
    }



    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        session()->flush();
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function test()
    {
        $test = [
            'status' => 'ok',
            'msg' => 'Welcome to ALOJAR API'
        ];


        return response()->json($test);
    }
}
