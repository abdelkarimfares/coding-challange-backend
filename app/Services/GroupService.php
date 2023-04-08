<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Group;
use App\Repositories\Api\GroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

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
    public function getGroups(int $perPage = 1): LengthAwarePaginator
    {
        return $this->groupRepository->getAllGroups($perPage);
    }

    /**
     * @inheritDoc
     */
    public function getGroup(int $id): Group
    {
        return $this->groupRepository->getById($id);
    }

    /**
     * @inheritDoc
     */
    public function addGroup(array $data): Group
    {
        $validator = ValidatorFacade::make($data, [
            'name' => 'required|unique:groups|max:60',
            'description' => 'required'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        return $this->groupRepository->createGroup($data);
    }

    /**
     * @inheritDoc
     */
    public function editGroup(int $id, array $data): Group
    {
        $validator = ValidatorFacade::make($data, [
            'name' => 'required|unique:groups,name,' . $id . '|max:60',
            'description' => 'required'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        return $this->groupRepository->updateGroup($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function deleteGroup(int $id): bool
    {
        return $this->groupRepository->deleteGroup($id);
    }
}
