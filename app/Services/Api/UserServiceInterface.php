<?php

namespace App\Services\Api;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NoSuchElementException;
use Symfony\Component\HttpKernel\Exception\InvalidMetadataException;

interface UserServiceInterface
{
    /**
     * Get All Users
     *
     * @return array
     */
    public function getUsers(): array;

    /**
     * Get single user by id
     *
     * @param int $id
     * @return User
     * @throws NoSuchElementException
     */
    public function getUser(int $id): User;

    /**
     * Add New User
     *
     * @param array $data
     * @return User
     * @throws InvalidMetadataException
     */
    public function addUser(array $data): User;

    /**
     * Edit Existing user
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function editUser(int $id, array $data): User;

    /**
     * Delete Existing user
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool;

}
