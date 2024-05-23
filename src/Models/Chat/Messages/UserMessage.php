<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

class UserMessage extends Message
{
    public function __construct(string|array $content, ?string $name = null)
    {
        parent::__construct($content, Role::USER, $name);
    }
}
