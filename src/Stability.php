<?php

declare(strict_types=1);

use Stability\Client;

class Stability
{
    /**
     * Creates a new Stability AI Client with the given API token.
     */
    public static function client(string $apiKey): Client
    {
        return new Client($apiKey);
    }
}
