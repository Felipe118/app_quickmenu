<?php

namespace App\Exceptions\Auth;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }

    /**
     * Render the exception to an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request) :JsonResponse
    {
        return response()->json([
            'message' => $this->message,
        ], $this->code);
    }
}
