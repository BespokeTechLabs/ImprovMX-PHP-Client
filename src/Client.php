<?php

namespace Bespoke\ImprovMX;

use Bespoke\ImprovMX\Api\Account;
use Bespoke\ImprovMX\Api\Alias;
use Bespoke\ImprovMX\Api\Domain;
use Bespoke\ImprovMX\Api\Log;
use Bespoke\ImprovMX\Api\SmtpCredential;
use GuzzleHttp\Client as HttpClient;

/**
 * This file is part of the ImprovMX API client library.
 *
 * (c) Lewis Smallwood <lewis@bespoke.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Client
{
    /**
     * @var string ImprovMX API URL.
     */
    public $api_url = 'https://api.improvmx.com/v3';

    /**
     * Request headers to be sent with each API request.
     * @var array
     */
    public $authentication_header = [];

    /**
     * @var string ImprovMX API Key.
     */
    private $api_key = null;

    /**
     * @var HttpClient|null Guzzle HTTP Client.
     */
    public $client = null;

    /**
     * API methods.
     */
    private $account;
    private $domains;
    private $aliases;
    private $logs;
    private $smtpCredentials;

    /**
     * Instantiate the ImprovMX client
     *
     * @param string $api_key
     */
    public function __construct($api_key)
    {
        $this->client = new HttpClient();

        $this->api_key = $api_key;
        $this->authentication_header = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic api:'.$api_key
            ]
        ];

        $this->account = new Account($this);
        $this->domains = new Domain($this);
        $this->aliases = new Alias($this);
        $this->logs = new Log($this);
        $this->smtpCredentials = new SmtpCredential($this);
    }

    public function account() {
        return $this->account;
    }

    public function domains() {
        return $this->domains;
    }

    public function aliases() {
        return $this->aliases;
    }

    public function logs() {
        return $this->logs;
    }

    public function smtpCredentials() {
        return $this->smtpCredentials;
    }
}
