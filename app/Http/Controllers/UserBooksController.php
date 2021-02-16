<?php

namespace App\Http\Controllers;

use BookApi\Request\Users\UserBooks\UserBooksRequest;
use BookApi\Request\Users\UserBooks\UserBooksStoreRequest;
use BookApi\Transformers\UserBooksTransformer;
use BookApi\Users\UserBooks\UserBooksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class UserBooksController
 * @package App\Http\Controllers
 */
class UserBooksController extends BaseController
{
    private UserBooksService $userBooksService;
    private UserBooksTransformer $transformer;

    /**
     * UserBooksController constructor.
     * @param UserBooksService $userBooksService
     * @param UserBooksTransformer $transformer
     */
    public function __construct(UserBooksService $userBooksService, UserBooksTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->userBooksService = $userBooksService;
    }

    /**
     * @param UserBooksStoreRequest $request
     * @param int $userId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(UserBooksStoreRequest $request, int $userId): JsonResponse
    {
        $validatedData = $request->validateRequest($userId);
        $createdUserBooks = $this->userBooksService->createUserBooks($userId, $validatedData['book_ids']);

        return response()->json(
            $this->transformer->response($this->transformer::STORE_RESPONSE, $validatedData, collect($createdUserBooks))
        );
    }

    /**
     * @param UserBooksRequest $request
     * @param int $userId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function index(UserBooksRequest $request, int $userId): JsonResponse
    {
        $validateData = $request->validateRequest($userId);
        $userBooks = $this->userBooksService->getUserBooks($userId);

        return response()->json(
            $this->transformer->response($this->transformer::INDEX_RESPONSE, $validateData, collect($userBooks))
        );
    }

}
