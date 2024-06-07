<?php

namespace StringPhp\Gpt;

use StringPhp\Gpt\Enums\Model;
use StringPhp\Gpt\Models\Chat\ChatCompletionRequest;
use StringPhp\Gpt\Models\Chat\ChatCompletionResponse;
use StringPhp\Gpt\Models\Chat\Messages\Message;
use StringPhp\Gpt\Models\ResponseFormat;
use StringPhp\Gpt\Models\ResponseFormatType;

class Gpt
{
    public function __construct(
        public readonly Http $http
    ) {

    }

    /**
     * @param Message[] $messages
     */
    public function chatCompletion(
        Model $model,
        array $messages,
        int $maxTokens = 150,
        int $n = 1,
        ?ResponseFormatType $responseFormat = null,
    ): ChatCompletionResponse {
        if ($responseFormat !== null) {
            $responseFormat = new ResponseFormat($responseFormat);
        }

        return ChatCompletionRequest::mapFromJson(array_filter(
            compact(
                'model',
                'messages',
                'maxTokens',
                'n',
                'responseFormat'
            ),
            static fn ($value) => $value !== null
        ))->send($this->http);
    }
}
