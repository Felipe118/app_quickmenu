<?php

namespace App\Exceptions\Address;

use Exception;

class SistemException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'Error:', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
