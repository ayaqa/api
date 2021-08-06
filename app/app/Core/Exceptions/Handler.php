<?php

namespace AyaQA\Core\Exceptions;

use AyaQA\Core\Exceptions\Base\APIException;
use AyaQA\Core\Exceptions\Contract\ProvidesFriendlyMessage;
use AyaQA\Core\Exceptions\Contract\ProvidesStatusCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // format all exceptions.
        $this->renderable(function (Throwable $e) {
            $errorResponseData = [
                'error' => true,
                'validation' => false,
                'message' => __('Something went wrong.')
            ];

            if ($e instanceof ProvidesFriendlyMessage) {
                $errorResponseData['message'] = $e->getFriendlyMessage();
            }

            $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($e instanceof ProvidesStatusCode) {
                $httpStatusCode = $e->getStatusCode();
            }

            if ($e instanceof ValidationException) {
                $errorResponseData['validation'] = true;
                $errorResponseData['message'] = __('There are validation errors.');
                $errorResponseData['messages'] = $e->errors();
            }

            $isDebug = config('app.debug');
            if ($isDebug) {
                $errorResponseData['__debug'] = [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json($errorResponseData, $httpStatusCode);
        });


        $this->reportable(function (Throwable $e) {

        });
    }
}
