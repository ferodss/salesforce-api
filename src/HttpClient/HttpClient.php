<?php
namespace Salesforce\HttpClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Perform requests on Salesforce API
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class HttpClient implements HttpClientInterface
{

    /**
     * @var array
     */
    protected $options = [
        'base_url'   => '',
        'timeout'    => 10,
        'user_agent' => 'PHP Salesforce API',
    ];

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * Instantiate a new HttpClient
     *
     * @param array $options
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $this->options = array_merge($this->options, $options);

        $client = $client ?: new GuzzleClient([
            'base_url' => $this->options['base_url'],
            'defaults' => [
                'headers' => $this->options
            ]
        ]);

        $this->client = $client;
        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($option, $value)
    {
        if (! array_key_exists($option, $this->options)) {
            throw new \InvalidArgumentException(sprintf(
                'Undefined option called: "%s"',
                $option
            ));
        }

        $this->options[$option] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getOption($option, $default = null)
    {
        return isset($this->options[$option]) ? $this->options[$option] : $default;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Reset headers to default
     *
     * @return void
     */
    public function clearHeaders()
    {
        $this->headers = [
            'Accept'     => 'application/xml',
            'User-Agent' => $this->options['user_agent'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, $body = null)
    {
        return $this->request($path, $body, 'POST');
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET')
    {
        $request = $this->createRequest($httpMethod, $path, $body);

        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            throw new \LogicException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * Create a request object to send to the server
     *
     * @param string $httpMethod
     * @param string $path
     * @param null   $body
     *
     * @return \GuzzleHttp\Message\RequestInterface
     */
    protected function createRequest($httpMethod, $path, $body = null)
    {
        return $this->client->createRequest(
            $httpMethod,
            $path,
            [
                'headers' => $this->headers,
                'body'    => $body,
            ]
        );
    }

}