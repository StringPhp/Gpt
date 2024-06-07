<?php

namespace StringPhp\Gpt\Models\Misc;

use StringPhp\Models\JsonModel;

class ImageUrl extends JsonModel
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}
