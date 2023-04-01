<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Api\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Throwable;

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
    public function getUsers(): array
    {
        return $this->userRepository->getAllUsers()->toArray();
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
            'type' => 'required|in:admin,customer',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->createUser($data);
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
            'type' => 'required|in:admin,customer',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable'
        ]);

        if (!$validator->errors()->isEmpty()) {
            throw new ValidationException($validator);
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->updateUser($id, $data);

    }

    /**
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException|Throwable
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->getById($id)
            ->deleteOrFail();
    }
}