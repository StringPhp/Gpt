<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\SnakeToCamelCaseModel;

class Choice extends SnakeToCamelCaseModel
{
    public string $finishReason;
    public int $index;

    #[ModelType(Message::class)]
    public Message $message;
}
