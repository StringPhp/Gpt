<?php

namespace StringPhp\Gpt\Models\Chat;

use StringPhp\Gpt\Endpoint;
use StringPhp\Gpt\Enums\Model;
use StringPhp\Gpt\Http;
use StringPhp\Gpt\Method;
use StringPhp\Gpt\Models\RequestModel;
use StringPhp\Gpt\Models\ResponseFormat;
use StringPhp\Gpt\Models\Traits\Messages;
use StringPhp\Models\DataTypes\ModelType;
use StringPhp\Models\DataTypes\NativeType;
use StringPhp\Models\Model as ModelAbstraction;

/**
 * @see https://platform.openai.com/docs/api-reference/chat/create
 */
class ChatCompletionRequest extends RequestModel
{
    use Messages;

    public Model $model;

    #[NativeType(NativeType::INT, false)]
    public int $maxTokens;

    #[NativeType(NativeType::INT, false)]
    public int $n;

    #[ModelType(ResponseFormat::class, false)]
    public ResponseFormat $responseFormat;

    /** @return ChatCompletionResponse */
    public function send(Http $http): ModelAbstraction
    {
        return $http->mapRequest(
            ChatCompletionResponse::class,
            Method::POST,
            Endpoint::bind(Endpoint::CHAT_CREATE),
            json_encode($this)
        );
    }
}
