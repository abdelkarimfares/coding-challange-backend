<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Group;
use App\Models\UserGroup;
use App\Repositories\Api\GroupRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
    public function getAllGroups(int $perPage): LengthAwarePaginator
    {
        if($perPage === -1 || !$perPage){
            $perPage = $this->group->count();
        }

        return $this->group->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): Group
    {
        return $this->group->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function createGroup(array $data): Group
    {
        $group = new Group();
        $group->name = $data['name'];
        $group->description = $data['description'];
        $group->save();
        return $group;
    }

    /**
     * @inheritDoc
     */
    public function updateGroup(int $id, array $data): Group
    {
        $group = $this->getById($id);
        $group->name = $data['name'];
        $group->description = $data['description'];
        $group->save();

        return $group;
    }

    /**
     * @inheritDoc
     */
    public function deleteGroup(int $id): bool
    {
        try {
            DB::beginTransaction();
            $group = $this->getById($id);
            UserGroup::where('group_id', $group->id)->delete();
            $deleted = $group->delete();
            DB::commit();

            return $deleted;
        }catch (\Throwable $ex){
            DB::rollBack();
            throw $ex;
        }
    }
}
