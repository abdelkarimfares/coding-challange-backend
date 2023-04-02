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
}
