<?php

namespace StringPhp\Gpt\Models;

use StringPhp\Models\Model;
use StringPhp\Models\DataTypes\EnumType;

class ResponseFormat extends Model
{
    #[EnumType(ResponseFormatType::class)]
    public ResponseFormatType $type;

    public function __construct(
        ResponseFormatType $type
    ) {
        $this->type = $type;
    }
}
