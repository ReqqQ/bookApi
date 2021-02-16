<?php

namespace BookApi\Users\UserBooks;

use BookApi\Books\BooksDbRepository;
use Illuminate\Support\Collection;

/**
 * Class UserBooksService
 * @package BookApi\Users\UserBooks
 */
class UserBooksService
{
    private UserBooksDbRepository $userBooksDbRepository;
    private BooksDbRepository $booksDbRepository;

    /**
     * UserBooksService constructor.
     * @param UserBooksDbRepository $userBooksDbRepository
     * @param BooksDbRepository $booksDbRepository
     */
    public function __construct(UserBooksDbRepository $userBooksDbRepository, BooksDbRepository $booksDbRepository)
    {
        $this->userBooksDbRepository = $userBooksDbRepository;
        $this->booksDbRepository = $booksDbRepository;
    }

    /**
     * @param int $userId
     * @param array $bookIds
     * @return array
     */
    public function createUserBooks(int $userId, array $bookIds): array
    {
        $bookIds = $this->prepareBookIdsToInsert($userId, $bookIds);
        $this->userBooksDbRepository->createUserBooks($bookIds);

        return $bookIds;
    }

    /**
     * @param int $userId
     * @param array $bookIds
     * @return array
     */
    private function prepareBookIdsToInsert(int $userId, array $bookIds): array
    {
        $resultArray = [];
        foreach ($bookIds as $bookId) {
            if ($this->userCanHaveBook($userId, $bookId)) {
                $resultArray[] = [
                    'user_id' => $userId,
                    'book_id' => (int)$bookId
                ];
            }
        }

        return $resultArray;
    }

    /**
     * @param int $userId
     * @param int $bookId
     * @return bool
     */
    private function userCanHaveBook(int $userId, int $bookId): bool
    {
        return !$this->userBooksDbRepository->userHasBook($userId, $bookId) &&
            $this->booksDbRepository->bookExists($bookId);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserBooks(int $userId): Collection
    {
        return $this->userBooksDbRepository->userBooks($userId);
    }
}
