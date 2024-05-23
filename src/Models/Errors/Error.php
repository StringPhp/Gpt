<?php

namespace StringPhp\Gpt\Models\Errors;

use StringPhp\Models\DataTypes\StringType;
use StringPhp\Models\SnakeToCamelCaseModel;

class Error extends SnakeToCamelCaseModel
{
    public string $message;
    public string $type;

    #[StringType(false)]
    public ?string $param;

    #[StringType(false)]
    public ?string $code;
}
