<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException; // Import the AuthorizationException class

class CustomException extends ExceptionHandler
{
    // ...

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        // Customize the response for AuthorizationException
        if ($exception instanceof AuthorizationException) {
            return response()->json(['error' => 'You are not authorized to access this resource.'], 403);
        }

        return parent::render($request, $exception);
    }
}
