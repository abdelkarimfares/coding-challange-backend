<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Group;
use App\Repositories\Api\GroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GroupService
 */
class GroupService implements Api\GroupServiceInterface
{
    public function __construct(
        protected GroupRepositoryInterface $groupRepository
    ){}

    /**
     * @inheritDoc
     */
    public function getGroups(): Collection
    {
        return $this->groupRepository->getAllGroups();
    }

    /**
     * @inheritDoc
     */
    public function getGroup(int $id): Group
    {
        return $this->groupRepository->getById($id);
    }
}
