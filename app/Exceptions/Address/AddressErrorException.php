<?php

namespace App\Exceptions\Address;

use Exception;

class AddressErrorException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'Erro ao registrar o endereço.', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
