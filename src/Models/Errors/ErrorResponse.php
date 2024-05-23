<?php

namespace StringPhp\Gpt\Models\Errors;

use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\SnakeToCamelCaseModel;

class ErrorResponse extends SnakeToCamelCaseModel
{
    #[ModelType(Error::class)]
    public Error $error;
}
