<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\UserGroup;
use App\Repositories\Api\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    public function getAllUsers(int $perPage): LengthAwarePaginator
    {
        return $this->user->paginate($perPage);
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
        $user = new User();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->age = $data['age'];
        $user->phone = $data['phone'];
        $user->type = $data['type'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->getById($id);
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->age = $data['age'];
        $user->phone = $data['phone'];
        if(isset($data['password']) && $data['password']){
            $user->password = Hash::make($data['password']);
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

    /**
     * @inheritDoc
     */
    public function deleteUser(int $id): bool
    {
        try {
            DB::beginTransaction();
            $user = $this->getById($id);
            UserGroup::where('user_id', $user->id)->delete();
            $deleted = $user->delete();
            DB::commit();

            return $deleted;
        }catch (\Throwable $ex){
            DB::rollBack();
            throw $ex;
        }
    }
}
