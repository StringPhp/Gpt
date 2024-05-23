<?php

namespace StringPhp\Gpt;

final class Endpoint
{
    public const BASE = 'https://api.openai.com/v1';
    public const CHAT_CREATE = '/chat/completions';

    public static function bind(string $endpoint, array $params = [], array $getParams = []): string
    {
        $endpoint = self::BASE . $endpoint;

        foreach ($params as $key => $value) {
            $endpoint = str_replace(":{$key}:", $value, $endpoint);
        }

        if (!empty($getParams)) {
            $endpoint .= '?' . http_build_query($getParams, '', '&');
        }

        return $endpoint;
    }
}
