<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (!config('app.debug') || $this->isHttpException($exception))
        {
            $response = [
                'message'           => $exception->getMessage(),
            ];

            $status                 = 500;

            //  HttpException checks
            if ($this->isHttpException($exception))
            {
                $status = $exception->getStatusCode();
                if ($status == 404)
                {
                    if (empty($response['message']))
                        $response['message'] = 'You are most likely trying access a route that does not exist. Check your spelling and syntax.';
                }
            }



            if (config('app.debug'))
            {
                $response['debug'] = [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'exception' => $exception->getTraceAsString()
                ];
            }

            return response()->json($response, $status);
        }

        return parent::render($request, $exception);
    }
}
