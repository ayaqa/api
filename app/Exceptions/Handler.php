<?php

namespace AyaQA\Exceptions;

use AyaQA\Actions\Core\GetAppDetails;
use AyaQA\Contracts\Core\Exception\HideExceptionMessage;
use AyaQA\Contracts\Core\Exception\HasResponseCode;
use AyaQA\Exceptions\Core\AyaQAException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AyaQAException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->customAppRendering();
    }

    /**
     * Will format default custom rendering
     *
     * @return void
     */
    protected function customAppRendering(): void
    {
        $getAppDetailsAction = $this->container->get(GetAppDetails::class);

        $this->renderable(function (AyaQAException $exception) use ($getAppDetailsAction) {

            $debugging = config('app.debug', false);

            $errorData = [
                'message' => $exception instanceof HideExceptionMessage ? __('errors.generic') : $exception->getMessage(),
                'details' => [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString()
                ],

            ];

            if ($debugging) {
                $request = request();
                $errorData['context'] = [
                    'app' => $getAppDetailsAction(),
                    'request' => [
                        'params' => $request->all(),
                        'route' => $request->route()
                    ]
                ];
            }

            if (false === $debugging) {
                unset($errorData['details']);
            }

            $responseCode = Response::HTTP_BAD_REQUEST;
            if ($exception instanceof HasResponseCode) {
                $responseCode = $exception->getHttpCode();
            }

            return response()->json($errorData, $responseCode);
        });
    }
}
