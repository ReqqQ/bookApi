<?php

namespace BookApi\Interfaces\Users;

use Illuminate\Support\Collection;

/**
 * Interface UsersDbRepositoryInterface
 * @package BookApi\Interfaces\Users
 */
interface UsersDbRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getUsers(): Collection;

    /**
     * @param array $data
     * @return int
     */
    public function createNewUser(array $data): int;

    /**
     * @param array $data
     * @param int $userId
     * @return int
     */
    public function updateCurrentUser(array $data, int $userId): int;

    /**
     * @param string $email
     * @param int $userId
     * @return int
     */
    public function deleteUser(string $email, int $userId): int;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUser(int $userId): Collection;

    /**
     * @param string $email
     * @param int $userId
     * @return bool
     */
    public function emailIsCorrect(string $email, int $userId): bool;
}
