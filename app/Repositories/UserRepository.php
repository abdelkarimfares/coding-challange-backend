<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Api\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
}
