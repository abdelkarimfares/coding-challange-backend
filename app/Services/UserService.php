<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Api\UserRepositoryInterface;

class UserService implements Api\UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    )
    {
    }

    public function getUsers(): array
    {
        return  [];
    }

    public function getUser(int $id): User
    {
        // TODO: Implement getUser() method.
    }

    public function addUser(array $data): User
    {
        // TODO: Implement addUser() method.
    }

    public function editUser(int $id, array $data): User
    {
        // TODO: Implement editUser() method.
    }

    public function deleteUser(int $id): bool
    {
        // TODO: Implement deleteUser() method.
    }
}
