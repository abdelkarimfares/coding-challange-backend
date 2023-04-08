<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface GroupRepositoryInterface
 */
interface GroupRepositoryInterface
{
    /**
     * Get All groups
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllGroups(int $perPage): LengthAwarePaginator;

    /**
     * Get group by id
     *
     * @param int $id
     * @return Group
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Group;

    /**
     * Create Group user
     *
     * @param array $data
     * @return Group
     */
    public function createGroup(array $data): Group;

    /**
     * Update Group Data
     *
     * @param int $id
     * @param array $data
     * @return Group
     * @throws ModelNotFoundException
     */
    public function updateGroup(int $id, array $data): Group;

    /**
     * delete group by id
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     * @throws \Throwable
     */
    public function deleteGroup(int $id): bool;
}
