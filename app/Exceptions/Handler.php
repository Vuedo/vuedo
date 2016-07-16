<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\ApiController;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            if ($request->segment(1) == 'api') {
                return (new ApiController())->errorNotFound($e->getMessage());
            }
        }
        if ($e instanceof AuthorizationException) {
            if ($request->segment(1) == 'api') {
                if($request->user()){
                    return (new ApiController())->errorUnauthorized('You need permission to perform this action.');
                }
                return (new ApiController())->errorForbidden('You are not logged in.');
            } else {
                return redirect('login');
            }
        }

        return parent::render($request, $e);
    }
}
