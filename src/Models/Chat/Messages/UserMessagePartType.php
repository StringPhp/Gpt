<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

enum UserMessagePartType: string
{
    case TEXT = 'text';
    case IMAGE = 'image_url';
}
