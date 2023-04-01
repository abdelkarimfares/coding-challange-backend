<?php
declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface UserServiceInterface
 */
interface GroupServiceInterface
{
    /**
     * Get All Groups
     *
     * @return Collection
     */
    public function getGroups(): Collection;

    /**
     * Get single group by id
     *
     * @param int $id
     * @return Group
     * @throws ModelNotFoundException
     */
    public function getGroup(int $id): Group;
}
