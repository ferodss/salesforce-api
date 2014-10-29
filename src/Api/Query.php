<?php
namespace Salesforce\Api;

use Salesforce\Client;
use Salesforce\HttpClient\Message\ResponseMediator;
use Salesforce\Event\QueryEvent;
use Salesforce\Event\ResponseEvent;

class Query
{

    /**
     * Salesforce Query REST API endpoint
     *
     * @var string
     */
    const ENDPOINT_PATTERN = 'https://%s.salesforce.com/services/data/v%s/';

    /**
     * Salesforce API client
     *
     * @var Client
     */
    protected $client;

    /**
     * @var \Salesforce\HttpClient\HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * Instantiate a new Salesforce Query API
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client     = $client;
        $this->httpClient = $client->getHttpClient();
        $this->endpoint   = sprintf(
            self::ENDPOINT_PATTERN,
            $this->client->getServerInstance(),
            Client::API_VERSION
        );

        $this->httpClient->setBaseUrl($this->endpoint);
    }

    /**
     * @return array
     */
    public function getAuthorizationHeader()
    {
        return array('Authorization' => 'Bearer ' . $this->client->getSessionId());
    }

    /**
     * Execute a Query in Salesforce API
     *
     * @param string $soql The Salesforce Object Query Language to execute
     *
     * @return \SimpleXMLElement
     */
    public function query($soql)
    {
        $queryString = array('q' => $soql);

        $requestEvent = new QueryEvent($this->endpoint . 'query', $queryString);
        $this->client->dispatch(Events::QUERY, $requestEvent);

        $this->httpClient->setHeaders($this->getAuthorizationHeader());
        $response = $this->httpClient->get('query', $queryString);
        $response = ResponseMediator::getContent($response);

        $this->client->dispatch(
            Events::RESPONSE,
            new ResponseEvent($requestEvent, $response->asXML())
        );

        return $response;
    }

}