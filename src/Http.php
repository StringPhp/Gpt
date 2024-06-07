<?php

namespace StringPhp\Gpt;

use Amp\ByteStream\StreamException;
use Amp\Http\Client\HttpClient;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use InvalidArgumentException;
use SensitiveParameter;
use StringPhp\Gpt\Exceptions\HttpException;
use StringPhp\Gpt\Models\Errors\ErrorResponse;
use StringPhp\Models\Exception\InvalidValue;
use StringPhp\Models\Exception\MissingRequiredValue;
use StringPhp\Models\Exception\ModelException;
use StringPhp\Models\JsonModel;
use StringPhp\Models\Model;
use Throwable;

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
     * @param class-string<T|JsonModel> $class
     * @param Method $method
     * @param string $uri
     * @param ?string $body
     * @param array $headers
     * @return T
     *
     * @throws HttpException
     */
    public function mapRequest(
        string $class,
        Method $method,
        string $uri,
        ?string $body = null,
        #[SensitiveParameter]
        array $headers = []
    ): mixed {
        if (!class_exists($class) || !is_subclass_of($class, Model::class)) {
            throw new InvalidArgumentException("{$class} is not a valid model class.");
        }

        $response = $this->request($method, $uri, $body, $headers);

        try {
            return [$class, 'map'](json_decode($response->getBody()->read(), true, flags: JSON_THROW_ON_ERROR));
        } catch (Throwable $e) {
            throw new HttpException($response, null, $e);
        }
    }

    /**
     * @template T
     *
     * @param class-string<T|JsonModel> $class
     * @param Method $method
     * @param string $uri
     * @param ?string $body
     * @param array $headers
     * @param callable|null $callback
     * @return T[]
     *
     * @throws InvalidValue If part of the response is invalid
     * @throws MissingRequiredValue If a required part of the response is missing
     * @throws StreamException
     * @throws ModelException|HttpException
     */
    public function arrayMapRequest(
        string $class,
        Method $method,
        string $uri,
        ?string $body = null,
        #[SensitiveParameter]
        array $headers = [],
        ?callable $callback = null
    ): array {
        $response = $this->request($method, $uri, $body, $headers);
        $mapped = [];

        try {
            $json = json_decode($response->getBody()->read(), true, flags: JSON_THROW_ON_ERROR);

            $json = $callback !== null ? $callback($json) : $json;

            foreach ($json as $item) {
                $mapped[] = [$class, 'mapFromJson']($item);
            }
        } catch (Throwable $e) {
            throw new HttpException($response, null, $e);
        }

        return $mapped;
    }

    /**
     * @param Response $response
     * @throws HttpException
     */
    protected function throwIfNotOkay(Response $response): void
    {
        if (str_starts_with($response->getStatus(), "2")) {
            return;
        }

        try {
            $error = ErrorResponse::mapFromJson(json_decode($response->getBody()->read(), true));
        } catch (Throwable $e) {
            throw new HttpException($response, null, $e);
        }

        throw new HttpException($response, $error);
    }

    /**
     * @throws HttpException
     */
    public function request(
        Method $method,
        string $uri,
        ?string $body = null,
        #[SensitiveParameter]
        array $headers = []
    ): Response {
        $request = new Request($uri, $method->value, $body);

        foreach ($this->mergeHeaders($headers) as $key => $value) {
            $request->setHeader($key, $value);
        }

        try {
            $response = $this->http->request($request);
        } catch (\Amp\Http\Client\HttpException $e) {
            throw new HttpException(previous: $e);
        }

        $this->throwIfNotOkay($response);

        return $response;
    }

    public function mergeHeaders(
        #[SensitiveParameter]
        array $headers = []
    ): array {
        $existingHeaders = [
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => 'application/json',
        ];

        return [...$existingHeaders, ...$headers];
    }
}
