<?php

namespace App\Exceptions;

use Exception;

class WrongLoginCredentials extends Exception
{

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'message' => 'Wrong login credentials',
        ], 401);
    }
}