<?php

namespace App\Http\Controllers;

use BookApi\Request\Users\UserDeleteRequest;
use BookApi\Request\Users\UserStoreRequest;
use BookApi\Request\Users\UserUpdateRequest;
use BookApi\Transformers\UserTransformer;
use BookApi\Users\UsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends BaseController
{
    private UserTransformer $transformer;
    private UsersService $usersService;

    /**
     * UsersController constructor.
     * @param UserTransformer $transformer
     * @param UsersService $usersService
     */
    public function __construct(UserTransformer $transformer, UsersService $usersService)
    {
        $this->usersService = $usersService;
        $this->transformer = $transformer;
    }

    /**
     * @param UserStoreRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validateRequest();
        $this->usersService->setRequestData($validatedData);
        $this->usersService->securePassword();
        $this->usersService->createUser();

        return response()->json(
            $this->transformer->response(
                $this->transformer::STORE_RESPONSE,
                $validatedData,
                collect([$this->usersService->requestData])
            )
        );
    }

    /**
     * @param UserUpdateRequest $request
     * @param int $userId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(UserUpdateRequest $request, int $userId): JsonResponse
    {
        $validatedData = $request->validateRequest($userId);

        $this->usersService->setRequestData($validatedData);
        $this->usersService->updateUser($userId);

        return response()->json(
            $this->transformer->response(
                $this->transformer::UPDATE_RESPONSE,
                $validatedData,
                collect([$this->usersService->requestData])
            )
        );
    }

    /**
     * @param UserDeleteRequest $request
     * @param int $userId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function delete(UserDeleteRequest $request, int $userId): JsonResponse
    {
        $validatedData = $request->validateRequest($userId);

        $this->usersService->setRequestData($validatedData);
        $this->usersService->deleteUser($userId);


        return response()->json(
            $this->transformer->response(
                $this->transformer::DELETE_RESPONSE,
                $validatedData,
                collect([$this->usersService->requestData])
            )
        );
    }

}
