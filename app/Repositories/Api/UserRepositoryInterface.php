<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * Get All users
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllUsers(int $perPage): LengthAwarePaginator;

    /**
     * Get user by id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
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

    /**
     * Delete user with attached groups
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException|Throwable
     */
    public function deleteUser(int $id): bool;

    /**
     * Attach groups to user
     *
     * @param User $user
     * @param array $groupsId
     * @return bool
     * @throws Throwable
     */
    public function attachGroups(User $user, array $groupsId): bool;
}
