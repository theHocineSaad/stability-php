<?php

declare(strict_types=1);

namespace Stability\Resources;

use Stability\Services\HttpService;

class Engines
{
    private HttpService $httpService;

    public function __construct(private array $parameters)
    {
        $this->httpService = $this->parameters['httpService'];
    }

    /**
     * List all engines available to your organization/user.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1engines/operation/listEngines
     */
    public function list(): array
    {
        $response = $this->httpService->sendRequest('GET', 'v1/engines/list', $this->parameters['headers']);

        return json_decode($response->getBody()->getContents(), true);
    }
}
