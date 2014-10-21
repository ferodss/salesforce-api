<?php
namespace Salesforce;

use Salesforce\Api\Bulk;
use Salesforce\HttpClient\HttpClient;
use Salesforce\HttpClient\HttpClientInterface;
use Salesforce\Exception\LoginFaultException;
use Salesforce\Soap\Result\LoginResult;
use Salesforce\Plugin\LogRequestsPlugin;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Psr\Log\LoggerInterface;

/**
 * Salesforce API Client
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Client
{

    /**
     * Supported Salesforce API version
     *
     * @var string
     */
    const API_VERSION = '32.0';

    /**
     * Salesforce REST API endpoint
     *
     * @var string
     */
    const REST_ENDPOINT_PATTERN = 'https://%s.salesforce.com/services/async/%s/';

    /**
     * Session header name for authorization
     *
     * @var string
     */
    const REST_SESSION_HEADER = 'X-SFDC-Session';

    /**
     * @var string
     */
    protected $wsdl;

    /**
     * @var Soap\SoapClient
     */
    protected $soapClient;

    /**
     * @var LoginResult
     */
    protected $loginResult;

    /**
     * HttpClient used to communicate with Salesforce
     *
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $restEndpoint;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Instantiate a new Salesforce client
     *
     * @param string                   $wsdl
     * @param null|HttpClientInterface $httpClient
     */
    public function __construct($wsdl, HttpClientInterface $httpClient = null)
    {
        $this->wsdl = $wsdl;

        if (null !== $httpClient) {
            $this->httpClient = $httpClient;
        }
    }

    /**
     * Enable logging
     *
     * @param LoggerInterface $logger
     *
     * @return Client
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        $logPlugin = new LogRequestsPlugin($this->logger);
        $this->getEventDispatcher()->addSubscriber($logPlugin);

        return $this;
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
        switch ($name) {
            case 'bulk':
                $api = new Bulk($this);
                break;

            default:
                throw new \InvalidArgumentException(sprintf(
                    'Undefined API instance called: "%s"',
                    $name
                ));
                break;
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests
     *
     * @param string $login
     * @param string $password
     * @param string $token
     *
     * @return Soap\Result\LoginResult
     *
     * @throws LoginFaultException
     */
    public function authenticate($login, $password, $token)
    {
        $loginResult = $this->getSoapClient()->authenticate($login, $password, $token);
        $this->setLoginResult($loginResult);

        return $loginResult;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return ! empty($this->loginResult);
    }

    /**
     * Get current session id through Salesforce SOAP API
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->getLoginResult()->getSessionId();
    }

    /**
     * @return array
     */
    public function getRestAuthorizationHeader()
    {
        return [Client::REST_SESSION_HEADER => $this->getSessionId()];
    }

    /**
     * Returns the used http client
     *
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient([
                'base_url' => $this->restEndpoint,
            ]);
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

    /**
     * Get URL for REST requests
     *
     * @return string
     */
    public function getRestEndpoint()
    {
        return $this->restEndpoint;
    }

    /**
     * Set event dispatcher
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get event dispatcher
     *
     * If no event dispatcher is supplied, a new one is created
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        if (null == $this->eventDispatcher) {
            $this->eventDispatcher = new EventDispatcher();
        }

        return $this->eventDispatcher;
    }

    /**
     * Dispatch an event
     *
     * @param string $name  Name of event: see Events.php
     * @param Event  $event Event object
     *
     * @return Event
     */
    public function dispatch($name, Event $event)
    {
        return $this->getEventDispatcher()->dispatch($name, $event);
    }

    /**
     * @param LoginResult $loginResult
     */
    protected function setLoginResult(LoginResult $loginResult)
    {
        $this->loginResult = $loginResult;

        $this->setSoapEndPoint();
        $this->setRestEndopint();
    }

    /**
     * Get login result from SOAP client
     *
     * @return LoginResult
     */
    protected function getLoginResult()
    {
        return $this->loginResult;
    }

    /**
     * @return void
     */
    protected function setRestEndopint()
    {
        $this->restEndpoint = sprintf(self::REST_ENDPOINT_PATTERN,
            $this->getLoginResult()->getServerInstance(),
            self::API_VERSION
        );
    }

    /**
     * @return void
     */
    protected function setSoapEndPoint()
    {
        $this->soapClient->setLocation($this->loginResult->getServerUrl());
    }

} 