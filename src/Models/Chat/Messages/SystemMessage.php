<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

class SystemMessage extends Message
{
    public function __construct(string $content, ?string $name = null)
    {
        parent::__construct($content, Role::SYSTEM, $name);
    }
}
