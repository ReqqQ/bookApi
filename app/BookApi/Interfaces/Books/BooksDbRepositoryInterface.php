<?php

namespace BookApi\Interfaces\Books;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface BooksDbRepositoryInterface
 * @package BookApi\Interfaces\Books
 */
interface BooksDbRepositoryInterface
{
    /**
     * @param array $parameters
     * @return Collection
     */
    public function getBooks(array $parameters): Collection;

    /**
     * @param array $requestData
     * @return int
     */
    public function insertBook(array $requestData): int;

    /**
     * @param array $requestData
     * @param int $bookId
     * @return int
     */
    public function updateBook(array $requestData, int $bookId): int;

    /**
     * @param int $bookId
     * @return int
     */
    public function deleteBook(int $bookId): int;

    /**
     * @param int $bookId
     * @return bool
     */
    public function bookExists(int $bookId): bool;
}
