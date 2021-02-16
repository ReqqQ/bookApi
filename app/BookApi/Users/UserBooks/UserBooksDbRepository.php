<?php

namespace BookApi\Users\UserBooks;

use App\Models\UserBooks;
use Illuminate\Support\Collection;

/**
 * Class UserBooksDbRepository
 * @package BookApi\Users\UserBooks
 */
class UserBooksDbRepository
{
    private UserBooks $userBooks;

    /**
     * UserBooksDbRepository constructor.
     * @param UserBooks $userBooks
     */
    public function __construct(UserBooks $userBooks)
    {
        $this->userBooks = $userBooks;
    }

    /**
     * @param array $bookIds
     * @return int
     */
    public function createUserBooks(array $bookIds): int
    {
        return $this->userBooks->insertOrIgnore($bookIds);
    }

    /**
     * @param int $userId
     * @param int $bookId
     * @return bool
     */
    public function userHasBook(int $userId, int $bookId): bool
    {
        return $this->userBooks->where('user_id', $userId)->where('book_id', $bookId)->exists();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function userBooks(int $userId): Collection
    {
        return $this->userBooks
            ->select(
                'book.id',
                'title',
                'description',
                'short_description'
            )
            ->join('book', 'book.id', '=', 'user_books.book_id')
            ->where('user_books.user_id', $userId)
            ->get();
    }
}
