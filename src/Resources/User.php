<?php

declare(strict_types=1);

namespace Stability\Resources;

use Stability\Services\HttpService;

class User
{
    private HttpService $httpService;

    public function __construct(private array $parameters)
    {
        $this->httpService = $this->parameters['httpService'];
    }

    /**
     * Get information about the account associated with the provided API key.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1user/operation/userAccount
     */
    public function account(): array
    {
        $response = $this->httpService->sendRequest('GET', 'v1/user/account', $this->parameters['headers']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get the credit balance of the account/organization associated with the API key.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1user/operation/userBalance
     */
    public function balance(): array
    {
        $response = $this->httpService->sendRequest('GET', 'v1/user/balance', $this->parameters['headers']);

        return json_decode($response->getBody()->getContents(), true);
    }
}
