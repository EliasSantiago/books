<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ItemNotFoundException extends Exception
{
    protected $statusCode = Response::HTTP_BAD_REQUEST;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (empty($message)) {
            $message = 'Ao menos um elemento <item> é obrigatório.';
        }

        parent::__construct($message, $this->statusCode, $previous);
    }
}