<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * Get All users
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Get user by id
     *
     * @param int $id
     * @return User
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): User;

    /**
     * Create new user
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Update User Data
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws ModelNotFoundException
     */
    public function updateUser(int $id, array $data): User;
}
