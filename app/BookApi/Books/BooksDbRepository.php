<?php

namespace BookApi\Books;

use App\Models\Books;
use BookApi\Interfaces\Books\BooksDbRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BooksDbRepository
 * @package BookApi\Books
 */
class BooksDbRepository implements BooksDbRepositoryInterface
{
    private Books $booksModel;

    /**
     * BooksDbRepository constructor.
     * @param Books $booksModel
     */
    public function __construct(Books $booksModel)
    {
        $this->booksModel = $booksModel;
    }

    /**
     * @param array $parameters
     * @return Collection
     */
    public function getBooks(array $parameters): Collection
    {
        return $this->titleFilter($this->booksModel, $parameters);
    }

    /**
     * @param Books $query
     * @param array $parameters
     * @return Collection
     */
    private function titleFilter(Books $query, array $parameters): Collection
    {
        if (isset($parameters['title'])) {
            $query = $query->where('title', 'like', "%{$parameters['title']}%");
        }

        return $query->get();
    }

    /**
     * @param array $requestData
     * @return int
     */
    public function insertBook(array $requestData): int
    {
        return $this->booksModel->insertOrIgnore($requestData);
    }

    /**
     * @param array $requestData
     * @param int $bookId
     * @return int
     */
    public function updateBook(array $requestData, int $bookId): int
    {
        return $this->booksModel->where('id', $bookId)->update($requestData);
    }

    /**
     * @param int $bookId
     * @return int
     */
    public function deleteBook(int $bookId): int
    {
        return $this->booksModel->where('id', $bookId)->delete();
    }

    /**
     * @param int $bookId
     * @return bool
     */
    public function bookExists(int $bookId): bool
    {
        return $this->booksModel->where('id', $bookId)->exists();
    }
}
