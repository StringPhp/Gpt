<?php

namespace StringPhp\Gpt\Models\Traits;

use StringPhp\Gpt\Models\Chat\Messages\Message;
use StringPhp\Models\DataTypes\ArrayType;
use StringPhp\Models\DataTypes\ModelType;

trait Messages
{
    #[ArrayType(new ModelType(Message::class, true))]
    public array $messages;

    public function addMessage(Message $message): void
    {
        $this->messages ??= [];
        $this->messages[] = $message;
    }
}
