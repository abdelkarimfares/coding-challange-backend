<?php
declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface UserServiceInterface
 */
interface GroupServiceInterface
{
    /**
     * Get All Groups
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getGroups(int $perPage = 20): LengthAwarePaginator;

    /**
     * Get single group by id
     *
     * @param int $id
     * @return Group
     * @throws ModelNotFoundException
     */
    public function getGroup(int $id): Group;

    /**
     * Add New group
     *
     * @param array $data
     * @return Group
     * @throws ValidationException
     */
    public function addGroup(array $data): Group;

    /**
     * Edit Existing group
     *
     * @param int $id
     * @param array $data
     * @return Group
     * @throws ValidationException
     */
    public function editGroup(int $id, array $data): Group;

    /**
     * Delete Existing group
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException|\Throwable
     */
    public function deleteGroup(int $id): bool;
}
