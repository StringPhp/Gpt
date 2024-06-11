<?php

namespace StringPhp\Gpt;

use StringPhp\Gpt\Enums\Model;
use StringPhp\Gpt\Exceptions\HttpException;
use StringPhp\Gpt\Models\Chat\ChatCompletionRequest;
use StringPhp\Gpt\Models\Chat\ChatCompletionResponse;
use StringPhp\Gpt\Models\Chat\Messages\Message;
use StringPhp\Gpt\Models\ResponseFormat;
use StringPhp\Gpt\Models\ResponseFormatType;
use StringPhp\Models\Exception\InvalidValue;
use StringPhp\Models\Exception\MissingRequiredValue;
use StringPhp\Models\Exception\ModelException;

class Gpt
{
    public function __construct(
        public readonly Http $http
    ) {

    }

    /**
     * @param Model $model
     * @param Message[] $messages
     * @param int $maxTokens
     * @param int $n
     * @param ResponseFormatType|null $responseFormat
     *
     * @return ChatCompletionResponse
     *
     * @throws HttpException
     * @throws InvalidValue
     * @throws MissingRequiredValue
     * @throws ModelException
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

        return ChatCompletionRequest::map(array_filter(
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
