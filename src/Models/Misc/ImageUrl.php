<?php

namespace StringPhp\Gpt\Models\Misc;

use StringPhp\Models\SnakeToCamelCaseModel;

class ImageUrl extends SnakeToCamelCaseModel
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}
