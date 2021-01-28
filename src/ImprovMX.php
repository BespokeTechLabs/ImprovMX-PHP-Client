<?php

namespace Bespoke\ImprovMX;


class ImprovMX
{
    private $client;

    public function __construct()
    {
        $apiKey = config("improvmx.api_key", "");
        $this->client = new Client($apiKey);
    }

    public function client() {
        return $this->client;
    }
}
