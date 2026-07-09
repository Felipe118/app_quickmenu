<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class SistemException extends Exception
{
    public function __construct(
        string $message = 'Erro interno.',
        protected int $status = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function status(): int
    {
        return $this->status;
    }
}
