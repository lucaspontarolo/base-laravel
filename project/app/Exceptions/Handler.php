<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Spatie\Permission\Exceptions\UnauthorizedException::class,
        \Illuminate\Validation\ValidationException::class,
        \League\OAuth2\Server\Exception\OAuthServerException::class,
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
    public function report(\Exception $exception)
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
    public function render($request, \Exception $exception)
    {
        if (config('app.debug')) {
            if ($exception instanceof NotFoundHttpException) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'error' => 'Route not found.'
                    ], 404);
                }
            }

            if ($exception instanceof ModelNotFoundException) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'error' => 'Registry not found.'
                    ], 404);
                }
            }

            if ($exception instanceof UnauthorizedException
                || $exception instanceof AuthorizationException
                || $exception instanceof ModelNotFoundException
            ) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'error' => 'Unauthorized.'
                    ], 403);
                }

                flash()->error(__('auth.invalid_role'));
                return redirect()->back();
            }

            if ($exception instanceof QueryException) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'error' => 'Internal Server Error.'
                    ], 500);
                }
            }
        }

        return parent::render($request, $exception);
    }
}
