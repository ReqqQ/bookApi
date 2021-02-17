<?php

namespace BookApi\Interfaces\Users\UserBooks;

use Illuminate\Support\Collection;

interface UserBooksDbRepositoryInterface
{
    public function createUserBooks(array $bookIds): int;

    public function userHasBook(int $userId, int $bookId): bool;

    public function userBooks(int $userId): Collection;
}
