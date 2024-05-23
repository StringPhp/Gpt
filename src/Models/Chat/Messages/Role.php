<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

enum Role: string
{
    case SYSTEM = 'system';
    case USER = 'user';
    case ASSISTANT = 'assistant';
}
