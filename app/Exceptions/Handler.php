<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * This mapping holds exceptions we're interested in and creates a simple configuration that can guide us
     * with formatting how it is rendered.
     *
     * @var array|array[]
     */
    protected array $exceptionMap = [
        ModelNotFoundException::class => [
            'code' => 404,
            'message' => 'Could not find what you were looking for.',
        ],
        ValidationException::class => [
            'code' => 422,
        ],
        InvalidArgumentException::class => [
            'code' => 400,
            'message' => 'You provided some invalid input value',
        ],
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response|JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception): Response|JsonResponse
    {
        $exceptionClass = get_class($exception);

        if (isset($this->exceptionMap[$exceptionClass])) {
            return $this->customExceptionResponse($exceptionClass, $exception);
        }

        return $this->customApiResponse($exception);
    }

    private function customExceptionResponse($exceptionClassName, $exception): JsonResponse
    {
        if ($exceptionClassName === ValidationException::class) {
            $this->exceptionMap[$exceptionClassName]['message'] = $exception->errors();
        }

        return response()->json($this->response($this->exceptionMap[$exceptionClassName]));
    }

    private function customApiResponse($exception): JsonResponse
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        }

        $response = [];
        $response['message'] = match ($statusCode) {
            Response::HTTP_NO_CONTENT => 'Nothing Changed',
            Response::HTTP_UNAUTHORIZED => 'Unauthorized',
            Response::HTTP_FORBIDDEN => 'Forbidden',
            Response::HTTP_NOT_FOUND => 'Could not find what you were looking for.',
            Response::HTTP_METHOD_NOT_ALLOWED => 'This method is not allowed for this endpoint.',
            Response::HTTP_UNPROCESSABLE_ENTITY => $exception->original['message'],
            default => $exception->getMessage(),
        };

        if ($statusCode === Response::HTTP_UNPROCESSABLE_ENTITY) {
            $response['errors'] = $exception->original['errors'];
        }

        $response['status'] = $statusCode;

        return response()->json($this->response($response));
    }

    private function response(array $response): array
    {
        return [
            'ver' => env('API_VER'),
            'timestamp' => time(),
            'method' => [],
            'error' => $response
        ];
    }
}
