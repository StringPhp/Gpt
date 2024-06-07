<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

use StringPhp\Gpt\Models\Misc\ImageUrl;
use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\DataTypes\StringType;
use StringPhp\Models\JsonModel;

class UserMessagePart extends JsonModel
{
    public UserMessagePartType $type;

    #[StringType(false)]
    public string $text;

    #[ModelType(ImageUrl::class, false)]
    public ImageUrl $imageUrl;

    public static function text(string $text): static
    {
        $that = new static();

        $that->type = UserMessagePartType::TEXT;
        $that->text = $text;

        return $that;
    }

    public static function image(string $imageUrl): static
    {
        $that = new static();

        $that->type = UserMessagePartType::IMAGE;
        $that->imageUrl = new ImageUrl($imageUrl);

        return $that;
    }
}
