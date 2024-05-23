<?php

namespace StringPhp\Gpt\Models\Chat\Messages;

use JsonSerializable;
use StringPhp\Models\DataTypes\ArrayType;
use StringPhp\Models\DataTypes\EnumType;
use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\DataTypes\NativeType;
use StringPhp\Models\SnakeToCamelCaseModel;

class Message extends SnakeToCamelCaseModel implements JsonSerializable
{
    #[ArrayType(new ModelType(UserMessagePart::class))]
    #[NativeType(NativeType::STRING, false)]
    public string|array $content;

    #[EnumType(Role::class)]
    public Role $role;

    #[NativeType(NativeType::STRING, false)]
    public string $name;

    public function __construct(
        string|array $content,
        Role $role,
        ?string $name = null
    ) {
        $this->content = $content;
        $this->role = $role;

        if ($name === null) {
            return;
        }

        $this->name = $name;
    }
}
