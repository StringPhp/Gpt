<?php

namespace StringPhp\Gpt\Exceptions;

use Amp\Http\Client\Response;
use Exception;
use StringPhp\Gpt\Models\Errors\ErrorResponse;
use Throwable;

class HttpException extends Exception
{
    public function __construct(
        public readonly ?Response $response = null,
        public readonly ?ErrorResponse $errorResponse = null,
        ?Throwable $previous = null
    )
    {
        parent::__construct(
            $errorResponse?->error?->message ?? 'Unknown error occurred.',
            previous: $previous
        );
    }
}
