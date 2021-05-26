<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class Handler
 *
 * @package App\Exceptions
 */
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param  Request  $request
     * @param  AuthenticationException  $exception
     *
     * @return JsonResponse|Response|RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|Response|RedirectResponse
    {
        if ($request->is('api/*')) {
            if (!$request->is('api/login')) {
                return response()->json(['error' => 'Unauthenticated.'], \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
            }
        }

        return redirect()->guest(route('login'));
    }
}
