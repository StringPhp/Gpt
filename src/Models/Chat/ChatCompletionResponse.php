<?php

namespace StringPhp\Gpt\Models\Chat;

use StringPhp\Gpt\Enums\Model;
use StringPhp\Gpt\Models\Chat\Messages\Choice;
use StringPhp\Gpt\Models\Misc\Usage;
use StringPhp\Models\DataTypes\ArrayType;
use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\DataTypes\StringType;
use StringPhp\Models\JsonModel;

class ChatCompletionResponse extends JsonModel
{
    public string $id;

    /** @var Choice[] */
    #[ArrayType(new ModelType(Choice::class))]
    public array $choices;

    public int $created;
    public Model $model;

    #[StringType(false)]
    public string $systemFingerprint;
    public string $object;

    #[ModelType(Usage::class)]
    public Usage $usage;

    public function firstChoice(): Choice
    {
        return $this->choices[0];
    }
}
