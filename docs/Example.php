<?php

use Amp\Http\Client\HttpClientBuilder;
use StringPhp\Gpt\Enums\Model;
use StringPhp\Gpt\Gpt;
use StringPhp\Gpt\Http;
use StringPhp\Gpt\Models\Chat\Messages\UserMessage;
use StringPhp\Gpt\Models\Chat\Messages\UserMessagePart;

require_once __DIR__ . '/../vendor/autoload.php';

$token = '<TOKEN_HERE>';

$http = new Http(HttpClientBuilder::buildDefault(), $token);
$gpt = new Gpt($http);

try {
    $response = $gpt->chatCompletion(
        Model::GPT_4o,
        [
            new UserMessage([
                UserMessagePart::text('Tell me what the following image contains.'),
                UserMessagePart::image('https://cdn.britannica.com/79/232779-050-6B0411D7/German-Shepherd-dog-Alsatian.jpg')
            ])
        ]
    );
} catch (Throwable $e) {
    echo $e;

    return;
}

echo $response->firstChoice()->message->content . PHP_EOL . "Used {$response->usage->totalTokens} tokens to generate the response.";
