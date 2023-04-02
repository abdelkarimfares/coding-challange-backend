<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult as AccessTokenResult;

/**
 * Auth service class
 */
class AuthService implements Api\AuthInterface
{
    /**
     * @inheritDoc
     */
    public function login(array $credentials): AccessTokenResult
    {
        $validator = ValidatorFacade::make($credentials, [
            'email' => 'required|email|string',
            'password' => 'required'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        if(!Auth::attempt($credentials)){
            throw new UnauthorizedException(__('Unauthorized'));
        }

        $user = Auth::getUser();

        return $user->createToken('login access token');
    }

    public function register(array $data): void
    {
        // TODO: Implement register() method.
    }

    public function logout(): void
    {
        // TODO: Implement logout() method.
    }
}
