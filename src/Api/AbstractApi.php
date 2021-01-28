<?php

namespace Bespoke\ImprovMX\Api;

use Bespoke\ImprovMX\Client;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class AbstractApi
{
    /**
     * @var Client $client API Client.
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function getHttpClient() {
        return $this->client->client;
    }

    /**
     * Make a get request through the API.
     * @param $slug
     * @return mixed|string|null
     */
    protected function getRequest($slug) {
        try {
            $response = $this->getHttpClient()->get($this->client->api_url."/".$slug, $this->client->authentication_header);
            return $this->returnData($response->getBody()->getContents());

        } catch (ClientException $e) {
            $response = $e->getResponse();
            return $this->returnData($response->getBody()->getContents());

        } catch (GuzzleException $e) {
            return null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Make a DELETE request through the API.
     * @param $slug
     * @return mixed|string|null
     */
    protected function deleteRequest($slug) {
        try {
            $response = $this->getHttpClient()->delete($this->client->api_url."/".$slug, $this->client->authentication_header);
            return $this->returnData($response->getBody()->getContents());

        } catch (ClientException $e) {
            $response = $e->getResponse();
            return $this->returnData($response->getBody()->getContents());

        } catch (GuzzleException $e) {
            return null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Make a post request through the API.
     * @param $slug
     * @param array $payload
     * @return mixed|string|null
     */
    protected function postRequest($slug, $payload = []) {
        try {
            $options = $this->client->authentication_header;
            $options["body"] = json_encode($payload);

            $response = $this->getHttpClient()->post($this->client->api_url."/".$slug, $options);
            return $this->returnData($response->getBody()->getContents());

        } catch (GuzzleException $e) {
            return null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Make a PUT request through the API.
     * @param $slug
     * @param array $payload
     * @return mixed|string|null
     */
    protected function putRequest($slug, $payload = []) {
        try {
            $options = $this->client->authentication_header;
            $options["body"] = json_encode($payload);

            $response = $this->getHttpClient()->put($this->client->api_url."/".$slug, $options);
            return $this->returnData($response->getBody()->getContents());

        } catch (GuzzleException $e) {
            return null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Parse returned JSON data from the API.
     * @param string $data
     * @return mixed|string
     */
    protected function returnData(string $data)
    {
        try {
            $data = json_decode($data, true);

            if (is_array($data) && array_key_exists("code", $data)) {
                if ($data["code"] == "UNABLE_TO_AUTHENTICATE") {
                    throw new Exception("Authentication error.");
                }
            }

            return $data;
        } catch (Exception $e) {
            return null;
        }
    }
}
