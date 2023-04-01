<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\UserGroup;
use App\Repositories\Api\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     */
    public function __construct(
        protected User $user
    ){}

    /**
     * @inheritDoc
     */
    public function getAllUsers(): Collection
    {
        return $this->user->get();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function createUser(array $data): User
    {
        $user = new User($data);
        $user->save();
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->getById($id);
        foreach ($data as $key => $value) {
            $user->setAttribute($key, $value);
        }
        $user->save();

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function attachGroups(User $user, array $groupsId): bool
    {
        try {
            DB::beginTransaction();
            $userGroups = array_map(static fn($id) => ['user_id' => $user->id, 'group_id' => $id], $groupsId);
            UserGroup::where('user_id', $user->id)->delete();
            $result = UserGroup::insert($userGroups);
            DB::commit();

            return $result;
        } catch (\Throwable $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}
