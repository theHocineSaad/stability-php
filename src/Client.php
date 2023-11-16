<?php

declare(strict_types=1);

namespace Stability;

use Stability\Resources\Engines;
use Stability\Resources\Generations;
use Stability\Resources\User;
use Stability\Services\HttpService;

class Client
{
    private string $baseUri = 'https://api.stability.ai/';

    private array $headers = [];

    private array $parameters = [];

    public function __construct(private string $apiKey)
    {
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];

        $this->setParameters();
    }

    private function setHeadersParameter(): void
    {
        $this->parameters['headers'] = $this->headers;
    }

    private function setParameters(): void
    {
        $this->parameters['apiKey'] = $this->apiKey;
        $this->parameters['headers'] = $this->headers;
        $this->parameters['httpService'] = new HttpService($this->baseUri);
    }

    /**
     * Adds the Accept HTTP header to the requests.
     * 
     * Default: "application/json".
     * 
     * Enum: "application/json", "image/png".
     * 
     * @param string $acceptHeaderValue
     * 
     */
    public function withAcceptHeader($acceptHeaderValue): self
    {
        $this->headers['Accept'] = $acceptHeaderValue;
        $this->setHeadersParameter();

        return $this;
    }

    /**
     * Adds the Organization HTTP header to the requests.
     * 
     * @param string $organizationHeaderValue
     * 
     */
    public function withOrganizationHeader($organizationHeaderValue): self
    {
        $this->headers['Organization'] = $organizationHeaderValue;
        $this->setHeadersParameter();

        return $this;
    }

    /**
     * Adds the Stability-Client-ID HTTP header to the requests.
     * 
     * @param string $stabilityClientIdHeaderValue
     * 
     */
    public function withStabilityClientIdHeader($stabilityClientIdHeaderValue): self
    {
        $this->headers['Stability-Client-ID'] = $stabilityClientIdHeaderValue;
        $this->setHeadersParameter();

        return $this;
    }

    /**
     * Adds the Stability-Client-Version HTTP header to the requests.
     * 
     * @param string $stabilityClientVersionHeaderValue
     * 
     */
    public function withStabilityClientVersionHeader($stabilityClientVersionHeaderValue): self
    {
        $this->headers['Stability-Client-Version'] = $stabilityClientVersionHeaderValue;
        $this->setHeadersParameter();
        
        return $this;
    }

    /**
     * Manage your Stability.ai account, and view account/organization balances.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1user
     */
    public function user(): User
    {
        return new User($this->parameters);
    }

    /**
     * Enumerate available engines.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1engines
     */
    public function engines(): Engines
    {
        return new Engines($this->parameters);
    }

    /**
     * Generate images from text, existing images, or both.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1generation
     */
    public function generations(): Generations
    {
        return new Generations($this->parameters);
    }
}
