<?php

namespace StringPhp\Gpt\Models\Misc;

use StringPhp\Models\SnakeToCamelCaseModel;

class Usage extends SnakeToCamelCaseModel
{
    public int $completionTokens;
    public int $promptTokens;
    public int $totalTokens;
}
