<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Api\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

/**
 * Class UserService
 */
class UserService implements Api\UserServiceInterface
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ){}

    /**
     * @inheritDoc
     */
    public function getUsers(int $perPage = 20): LengthAwarePaginator
    {
        return $this->userRepository->getAllUsers($perPage);
    }

    /**
     * @inheritDoc
     */
    public function getUser(int $id): User
    {
        return $this->userRepository->getById($id);
    }

    /**
     * @inheritDoc
     */
    public function addUser(array $data): User
    {
        $validator = ValidatorFacade::make($data, [
            'username' => 'required|unique:users|max:60',
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'phone' => 'required|max:10',
            'age' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'groups.*' => 'nullable|integer|exists:App\Models\Group,id'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        $data = $validator->valid();
        $groups = $data['groups'] ?? [];

        try {
            DB::beginTransaction();
            $user = $this->userRepository->createUser($data);
            $this->userRepository->attachGroups($user, $groups);
            DB::commit();
        }catch (\Throwable $ex){
            DB::rollBack();
            throw $ex;
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function editUser(int $id, array $data): User
    {
        $validator = ValidatorFacade::make($data, [
            'username' => 'required|unique:users,username,' . $id . '|max:60',
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'phone' => 'required|max:10',
            'age' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            'groups.*' => 'nullable|integer|exists:App\Models\Group,id'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        $groups = $data['groups'] ?? [];

        $user = $this->userRepository->updateUser($id, $data);
        $this->userRepository->attachGroups($user, $groups);

        return $user;

    }

    /**
     * @inheritDoc
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->deleteUser($id);
    }

    /**
     * @inheritDoc
     */
    public function attachUserToGroups(int $userId, array $groupsId): bool
    {
        $validator = ValidatorFacade::make(['ids' => $groupsId], [
            'ids.*' => 'nullable|integer|exists:App\Models\Group,id',
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        $user = $this->userRepository->getById($userId);

        return $this->userRepository->attachGroups($user, $groupsId);
    }
}
