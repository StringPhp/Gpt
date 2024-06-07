<?php

namespace StringPhp\Gpt\Models\Errors;

use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\JsonModel;

class ErrorResponse extends JsonModel
{
    #[ModelType(Error::class)]
    public Error $error;
}
