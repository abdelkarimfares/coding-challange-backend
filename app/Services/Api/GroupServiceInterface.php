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
}
