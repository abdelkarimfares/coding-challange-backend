<?php
declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\PersonalAccessTokenResult as AccessTokenResult;

interface AuthInterface
{
    /**
     * @param array $credentials
     * @return AccessTokenResult
     * @throws ValidationException
     * @throws UnauthorizedException
     */
    public function login(array $credentials): AccessTokenResult;

    /**
     * @param array $data
     * @return void
     */
    public function register(array $data): void;

    /**
     * @return void
     */
    public function logout(): void;
}
