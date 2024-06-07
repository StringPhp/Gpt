<?php

namespace StringPhp\Gpt\Models\Misc;

use StringPhp\Models\JsonModel;

class Usage extends JsonModel
{
    public int $completionTokens;
    public int $promptTokens;
    public int $totalTokens;
}
