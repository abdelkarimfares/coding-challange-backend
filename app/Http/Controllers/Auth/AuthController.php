<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\AuthInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

/**
 * Auth Controller Class
 */
class AuthController extends Controller
{
    /**
     * @param AuthInterface $authService
     */
    public function __construct(
        protected AuthInterface $authService
    ){}

    /**
     * User Login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $accessToken = $this->authService->login($credentials);

            return response()->json([
                'access_token' => $accessToken->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $accessToken->token->expires_at
                )->toDateTimeString()
            ]);
        } catch (ValidationException $ex) {
            return response()->json(['errors' => $ex->errors()], 403);
        }
        catch (UnauthorizedException $ex) {
            return response()->json(['message' => $ex->getMessage()], 401);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {

    }
}
