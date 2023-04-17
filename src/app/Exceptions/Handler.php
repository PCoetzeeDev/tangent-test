<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable|null $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e = null)
    {
//        if($request->header('Content-Type') == 'application/json') {
//            if ($e !== null) {
//                $response = [
//                    'error' => 'Unknown error occurred'
//                ];
//
//                // If debug mode is enabled
//                if (config('app.debug')) {
//                    // Add the exception class name, message and stack trace to response
//                    $response['exception'] = get_class($e); // Reflection might be better here
//                    $response['message'] = $e->getMessage();
//                    $response['trace'] = $e->getTrace();
//                }
//
//                $status = 400;
//                if($e instanceof ValidationException){
//                    return $this->convertValidationExceptionToResponse($e, $request);
//                }elseif($e instanceof AuthenticationException){
//                    $status = 401;
//                    $response['error'] = 'Authentication Failed';
//
//                }elseif($e instanceof \PDOException){
//                    $status = 500;
//                    $response['error'] = 'Internal Server Error';
//
//                }elseif($this->isHttpException($e)){
//                    $status = $e->getStatusCode();
//                    $response['error'] = 'Bad Request';
//
//                }else{
//                    $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 400;
//                }
//
//                return response()->json($response,$status);
//            }
//        }

        return parent::render($request, $e);
    }
}
