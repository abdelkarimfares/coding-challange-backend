<?php
declare(strict_types=1);
namespace App\Services\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NoSuchElementException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface UserServiceInterface
 */
interface UserServiceInterface
{
    /**
     * Get All Users
     *
     * @return Collection
     */
    public function getUsers(): Collection;

    /**
     * Get single user by id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUser(int $id): User;

    /**
     * Add New User
     *
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function addUser(array $data): User;

    /**
     * Edit Existing user
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function editUser(int $id, array $data): User;

    /**
     * Delete Existing user
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException|\Throwable
     */
    public function deleteUser(int $id): bool;

}
