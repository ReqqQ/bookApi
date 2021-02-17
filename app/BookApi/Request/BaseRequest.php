<?php

namespace BookApi\Request;

use BookApi\Interfaces\Request\RequestInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class BaseRequest
 * @package BookApi\Request
 */
abstract class BaseRequest implements RequestInterface
{
    use ProvidesConvenienceMethods;

    public Request $request;

    /**
     * BaseRequest constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param null $userId
     * @return array
     * @throws ValidationException
     */
    public function validateRequest($userId = null): array
    {
        if ($userId !== null) {
            $this->validateCurrentUser($userId);
        }

        return $this->validate($this->request, $this->rules());
    }

    /**
     * @param int $userId
     */
    public function validateCurrentUser(int $userId): void
    {
        if (JWTAuth::parseToken()->authenticate()->id !== $userId) {
            throw new HttpException(Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @return array
     */
    abstract protected function rules(): array;
}
