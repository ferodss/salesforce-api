<?php
namespace Salesforce;

use Salesforce\HttpClient\HttpClient;
use Salesforce\HttpClient\HttpClientInterface;
use Salesforce\Api\ApiFactory;

/**
 * Class Client
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Client
{

    /**
     * Supported API version
     */
    const API_VERSION = '32.0';

    /**
     * @var string
     */
    protected $wsdl;

    /**
     * @var Soap\SoapClient
     */
    protected $soapClient;

    /**
     * HttpClient used to communicate with Salesforce
     *
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * Instantiate a new Salesforce client
     *
     * @param string                   $wsdl
     * @param null|HttpClientInterface $httpClient
     */
    public function __construct($wsdl, HttpClientInterface $httpClient = null)
    {
        $this->wsdl       = $wsdl;
        $this->httpClient = $httpClient ?: $this->getHttpClient();
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
        return ApiFactory::factory($name);
    }

    /**
     * Authenticate a user for all next requests
     *
     * @param string $login
     * @param string $password
     * @param string $token
     *
     * @return Soap\Result\LoginResult
     */
    public function authenticate($login, $password, $token)
    {
        return $this->getSoapClient()->authenticate($login, $password, $token);
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

    /**
     * @param Soap\SoapClientInterface $soapClient
     *
     * @return Client
     */
    public function setSoapClient(Soap\SoapClientInterface $soapClient)
    {
        $this->soapClient = $soapClient;

        return $this;
    }

    /**
     * @return Soap\SoapClient
     */
    public function getSoapClient()
    {
        if (null === $this->soapClient) {
            $this->soapClient = Soap\SoapClientFactory::factory($this->wsdl);
        }

        return $this->soapClient;
    }

} 