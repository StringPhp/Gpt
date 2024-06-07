<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\JsonModel;

class Choice extends JsonModel
{
    public string $finishReason;
    public int $index;

    #[ModelType(Message::class)]
    public Message $message;
}
