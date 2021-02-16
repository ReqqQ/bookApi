<?php

namespace BookApi\Users;

use App\Models\Users;
use Illuminate\Support\Collection;

/**
 * Class UsersDbRepository
 * @package BookApi\Users
 */
class UsersDbRepository
{
    public Users $userModel;

    /**
     * UsersDbRepository constructor.
     * @param Users $userModel
     */
    public function __construct(Users $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->userModel->all();
    }

    /**
     * @param array $data
     * @return int
     */
    public function createNewUser(array $data): int
    {
        return $this->userModel->insertOrIgnore($data);
    }

    /**
     * @param array $data
     * @param int $userId
     * @return int
     */
    public function updateCurrentUser(array $data, int $userId): int
    {
        return $this->userModel->where('id', $userId)->update($data);
    }

    /**
     * @param string $email
     * @param int $userId
     * @return int
     */
    public function deleteUser(string $email, int $userId): int
    {
        return $this->userModel->where('id', $userId)->where('email', $email)->delete();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUser(int $userId): Collection
    {
        return $this->userModel->where('id', $userId)->get();
    }

    /**
     * @param string $email
     * @param int $userId
     * @return bool
     */
    public function emailIsCorrect(string $email, int $userId): bool
    {
        return $this->userModel->where('id', $userId)->where('email', $email)->exists();
    }
}
