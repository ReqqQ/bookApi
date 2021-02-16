<?php

namespace BookApi\Books;

use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class BooksService
 * @package BookApi\Books
 */
class BooksService
{
    private const NOTHING_CHANGED_STATUS = 0;
    private BooksDbRepository $booksDbRepository;

    /**
     * BooksService constructor.
     * @param BooksDbRepository $booksDbRepository
     */
    public function __construct(BooksDbRepository $booksDbRepository)
    {
        $this->booksDbRepository = $booksDbRepository;
    }

    /**
     * @param array $parameters
     * @return Collection
     */
    public function getBooks(array $parameters): Collection
    {
        return $this->booksDbRepository->getBooks(array_filter($parameters));
    }

    /**
     * @param array $parameters
     */
    public function insertBook(array $parameters): void
    {
        $status = $this->booksDbRepository->insertBook($parameters);

        if ($status === self::NOTHING_CHANGED_STATUS) {
            throw new HttpException(Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * @param array $requestData
     * @param int $bookId
     * @return int
     */
    public function updateBook(array $requestData, int $bookId): int
    {
        return $this->booksDbRepository->updateBook($requestData, $bookId);
    }

    /**
     * @param int $bookId
     * @return int
     */
    public function deleteBook(int $bookId): int
    {
        return $this->booksDbRepository->deleteBook($bookId);
    }
}
