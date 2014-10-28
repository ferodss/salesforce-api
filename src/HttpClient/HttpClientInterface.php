<?php
namespace Salesforce\HttpClient;

/**
 * Perform requests on Salesforce API
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
interface HttpClientInterface
{

    /**
     * Send a GET request
     *
     * @param string $path       Request path
     * @param array  $parameters GET parameters
     *
     * @return \Guzzle\Http\Message\Response
     *
     * @throws \LogicException
     */
    public function get($path, array $parameters = array());

    /**
     * Send a POST request
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     *
     * @return \Guzzle\Http\Message\Response
     *
     * @throws \LogicException
     */
    public function post($path, $body = null);

    /**
     * Send a request to the server
     *
     * @param string $path          Request path
     * @param mixed  $body          Request body
     * @param string $httpMethod    HTTP method to use
     * @param array  $options
     *
     * @return \Guzzle\Http\Message\Response
     *
     * @throws \LogicException
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $options = array());

    /**
     * Change an option value
     *
     * @param string $option The option name
     * @param mixed  $value  The value
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function setOption($option, $value);

    /**
     * Get an option value
     *
     * @param string $option  The option name
     * @param mixed  $default Default value to return, defaults to null
     *
     * @return mixed
     */
    public function getOption($option, $default = null);

    /**
     * Set HTTP headers
     *
     * @param array $headers
     */
    public function setHeaders(array $headers);

    /**
     * Get HTTP headers
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Set the base URL for next HTTP calls
     *
     * @param string $url
     *
     * @return HttpClientInterface
     */
    public function setBaseUrl($url);

    /**
     * Get the base URL of HTTP client
     *
     * @return string
     */
    public function getBaseUrl();

}