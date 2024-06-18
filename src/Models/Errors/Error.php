<?php

namespace StringPhp\Gpt\Models\Errors;

use StringPhp\Models\DataTypes\NullType;
use StringPhp\Models\DataTypes\StringType;
use StringPhp\Models\JsonModel;

class Error extends JsonModel
{
    public string $message;
    public string $type;

    #[StringType(false)]
    #[NullType(false)]
    public ?string $param;

    #[StringType(false)]
    public ?string $code;
}
