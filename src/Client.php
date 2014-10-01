<?php
namespace Salesforce;

use Salesforce\HttpClient\HttpClient;
use Salesforce\HttpClient\HttpClientInterface;
use Salesforce\Api\ApiFactory;

class Client
{

    /**
     * Supported API version
     */
    const API_VERSION = 'v32.0';

    /**
     * HttpClient used to communicate with Salesforce
     *
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * Instantiate a new Salesforce client
     *
     * @param null|HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Return a given API instance
     *
     * @param string $name The API name
     *
     * @return mixed
     */
    public function api($name)
    {
        return ApiFactory::getApi($name);
    }

    /**
     * Returns the used http client
     *
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient;
    }

} 