<?php

namespace StringPhp\Gpt;

use Amp\Http\Client\HttpClient;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use InvalidArgumentException;
use SensitiveParameter;
use StringPhp\Gpt\Exceptions\HttpException;
use StringPhp\Gpt\Models\Errors\ErrorResponse;
use StringPhp\Models\Exception\InvalidValue;
use StringPhp\Models\Exception\MissingRequiredValue;
use StringPhp\Models\Model;

class Http
{
    public function __construct(
        protected HttpClient $http,
        #[SensitiveParameter]
        protected string $token
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T|Model> $class
     * @param ?string $body
     *
     * @throws InvalidArgumentException If class doesn't exist or is not a subclass of Model
     * @throws InvalidValue If part of the response is invalid
     * @throws MissingRequiredValue If a required part of the response is missing
     *
     * @return T
     */
    public function mapRequest(string $class, Method $method, string $uri, ?string $body = null, array $headers = []): mixed
    {
        if (!class_exists($class) || !is_subclass_of($class, Model::class)) {
            throw new InvalidArgumentException("{$class} is not a valid model class.");
        }

        $response = $this->request($method, $uri, $body, $headers);

        return [$class, 'map'](json_decode($response->getBody()->read(), true));
    }

    /**
     * @template T
     *
     * @param class-string<T|Model> $class
     * @param ?string $body
     *
     * @throws InvalidArgumentException If class doesn't exist or is not a subclass of Model
     * @throws InvalidValue If part of the response is invalid
     * @throws MissingRequiredValue If a required part of the response is missing
     *
     * @return T
     */
    public function arrayMapRequest(Model $class, Method $method, string $uri, ?string $body = null, array $headers = [], ?callable $callback = null): array
    {
        $response = $this->request($method, $uri, $body, $headers);
        $mapped = [];

        $json = json_decode($response->getBody()->read(), true);

        $json = $callback !== null ? $callback($json) : $json;

        foreach ($json as $item) {
            $mapped[] = [$class, 'map']($item);
        }

        return $mapped;
    }

    /**
     * @throws HttpException
     */
    protected function throwIfNotOkay(Response $response): void
    {
        if ($response->getStatus() === 200) {
            return;
        }

        $error = ErrorResponse::map(json_decode($response->getBody()->read(), true));

        throw new HttpException($error);
    }

    public function request(Method $method, string $uri, ?string $body = null, array $headers = []): Response
    {
        $request = new Request($uri, $method->value, $body);

        foreach ($this->mergeHeaders($headers) as $key => $value) {
            $request->setHeader($key, $value);
        }

        $response = $this->http->request($request);

        $this->throwIfNotOkay($response);

        return $response;
    }

    public function mergeHeaders(array $headers = []): array
    {
        $existingHeaders = [
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => 'application/json',
        ];

        return [...$existingHeaders, ...$headers];
    }
}
