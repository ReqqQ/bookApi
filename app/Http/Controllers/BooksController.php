<?php

namespace App\Http\Controllers;

use BookApi\Books\BooksService;
use BookApi\Request\Books\BooksRequest;
use BookApi\Request\Books\BooksStoreRequest;
use BookApi\Transformers\BooksTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController extends BaseController
{
    private BooksTransformer $transformer;
    private BooksService $booksService;

    /**
     * BooksController constructor.
     * @param BooksTransformer $transformer
     * @param BooksService $booksService
     */
    public function __construct(BooksTransformer $transformer, BooksService $booksService)
    {
        $this->booksService = $booksService;
        $this->transformer = $transformer;
    }

    /**
     * @param BooksRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function index(BooksRequest $request): JsonResponse
    {
        $validatedData = $request->validateRequest();
        $books = $this->booksService->getBooks($validatedData);

        return response()->json(
            $this->transformer->response($this->transformer::INDEX_RESPONSE, $request->request->all(), $books)
        );
    }

    /**
     * @param BooksStoreRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(BooksStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validateRequest();
        $this->booksService->insertBook($validatedData);

        return response()->json(
            $this->transformer->response($this->transformer::STORE_RESPONSE, $validatedData, collect([$validatedData]))
        );
    }

    /**
     * @param BooksRequest $request
     * @param int $bookId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(BooksRequest $request, int $bookId): JsonResponse
    {
        $validatedData = $request->validateRequest();
        $this->booksService->updateBook($validatedData, $bookId);

        return response()->json(
            $this->transformer->response($this->transformer::UPDATE_RESPONSE, $validatedData, collect([$validatedData]))
        );
    }

    /**
     * @param int $bookId
     * @return JsonResponse
     */
    public function delete(int $bookId): JsonResponse
    {
        $requestData['bookId'] = $bookId;
        $this->booksService->deleteBook($bookId);

        return response()->json(
            $this->transformer->response($this->transformer::DELETE_RESPONSE, $requestData, collect([$requestData]))
        );
    }

}
