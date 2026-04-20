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

/**
 * Class AuthController
 * @package App\Http\Controllers\API
 *
 *
 * @SWG\Definition(
 *   definition="LoginRequest",
 *   type="object",
 *   required={"email", "password"},
 *   @SWG\Property(property="email", type="string", format="email", description="User email address"),
 *   @SWG\Property(property="password", type="string", format="password", description="User password")
 * )
 *
 * @SWG\Definition(
 *   definition="GoogleSignInRequest",
 *   type="object",
 *   required={"credential"},
 *   @SWG\Property(property="credential", type="string", description="Google JWT credential")
 * )
 *
 * @SWG\Definition(
 *   definition="AuthResponse",
 *   type="object",
 *   @SWG\Property(property="token", type="string", description="JWT access token"),
 *   @SWG\Property(property="token_type", type="string", description="Token type", example="bearer"),
 *   @SWG\Property(property="expires_in", type="integer", description="Token expiration time in seconds"),
 *   @SWG\Property(
 *       property="user",
 *       type="object",
 *       @SWG\Property(property="id", type="integer"),
 *       @SWG\Property(property="name", type="string"),
 *       @SWG\Property(property="email", type="string"),
 *       @SWG\Property(property="logins", type="integer")
 *   )
 * )
 *
 * @SWG\Definition(
 *   definition="User",
 *   type="object",
 *   @SWG\Property(property="id", type="integer", description="User ID", readOnly=true),
 *   @SWG\Property(property="name", type="string", description="User name"),
 *   @SWG\Property(property="email", type="string", format="email", description="User email"),
 *   @SWG\Property(property="google_id", type="string", description="Google user ID"),
 *   @SWG\Property(property="picture", type="string", description="User profile picture URL"),
 *   @SWG\Property(property="logins", type="integer", description="Login count"),
 *   @SWG\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *   @SWG\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */
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
     *
     * @SWG\Post(
     *      path="/auth/authenticate",
     *      summary="User login",
     *      tags={"Authentication"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="User credentials",
     *          @SWG\Schema(ref="#/definitions/LoginRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful login",
     *          @SWG\Schema(ref="#/definitions/AuthResponse")
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Bad credentials"
     *      )
     * )
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

    /**
     * Authenticate user with Google credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *      path="/auth/google_signin",
     *      summary="Google sign-in",
     *      tags={"Authentication"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="Google credential",
     *          @SWG\Schema(ref="#/definitions/GoogleSignInRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful Google login",
     *          @SWG\Schema(ref="#/definitions/AuthResponse")
     *      ),
     *      @SWG\Response(
     *          response=403,
     *          description="Bad Google credentials"
     *      )
     * )
     */
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
            logger($e);
        }
        $user = auth()->user();

        $stores = $user->myStores();
        session()->put('stores', $stores);

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
     *
     * @SWG\Get(
     *      path="/auth/account",
     *      summary="Get authenticated user information",
     *      tags={"Authentication"},
     *      security={{"jwt":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *      path="/auth/logout",
     *      summary="User logout",
     *      tags={"Authentication"},
     *      security={{"jwt":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="Successfully logged out",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="message", type="string", example="Successfully logged out")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
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
     *
     * @SWG\Post(
     *      path="/auth/refresh",
     *      summary="Refresh authentication token",
     *      tags={"Authentication"},
     *      security={{"jwt":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="Token refreshed successfully",
     *          @SWG\Schema(ref="#/definitions/AuthResponse")
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
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
        $ttl = auth()->factory()->getTTL();

        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
            'token_type' => 'bearer',
            'expires_in' => $ttl !== null ? $ttl * 60 : null
        ]);
    }

    /**
     * Test endpoint.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/auth/test",
     *      summary="Test API endpoint",
     *      tags={"Authentication"},
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="status", type="string", example="ok"),
     *              @SWG\Property(property="msg", type="string", example="Welcome to ALOJAR API")
     *          )
     *      )
     * )
     */
    public function test()
    {
        $test = [
            'status' => 'ok',
            'msg' => 'Welcome to FERIAR API'
        ];


        return response()->json($test);
    }
}
