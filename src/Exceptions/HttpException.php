<?php

namespace StringPhp\Gpt\Exceptions;

use Exception;
use StringPhp\Gpt\Models\Errors\ErrorResponse;

class HttpException extends Exception
{
    public function __construct(ErrorResponse $errorResponse)
    {
        parent::__construct($errorResponse->error->message);
    }
}
