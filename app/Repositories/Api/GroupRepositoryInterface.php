<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface GroupRepositoryInterface
 */
interface GroupRepositoryInterface
{
    /**
     * Get All groups
     *
     * @return Collection
     */
    public function getAllGroups(): Collection;

    /**
     * Get group by id
     *
     * @param int $id
     * @return Group
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Group;
}
