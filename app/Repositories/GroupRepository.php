<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Group;
use App\Repositories\Api\GroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Group repository layer
 */
class GroupRepository implements GroupRepositoryInterface
{
    /**
     * @param Group $group
     */
    public function __construct(
        protected Group $group
    ){}

    /**
     * @inheritDoc
     */
    public function getAllGroups(): Collection
    {
        return $this->group->get();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): Group
    {
        return $this->group->findOrFail($id);
    }
}
