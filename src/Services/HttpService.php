<?php

namespace Stability\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HttpService
{
    private Client $httpClient;

    public function __construct(private string $baseUrl)
    {
        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
    }

    public function sendRequest(string $method, string $uri, array $headers, array $payload = null, string $payloadType = 'json'): ResponseInterface
    {
        $options = $payload ? [
            'headers' => $headers,
            $payloadType => $payload,
        ] : [
            'headers' => $headers,
        ];

        return $this->httpClient->request($method, $uri, $options);
    }
}
