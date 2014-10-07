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
     * Send a POST request
     *
     * @param string $path    Request path
     * @param mixed  $body    Request body
     *
     * @return mixed
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
     *
     * @return mixed
     *
     * @throws \LogicException
     */
    public function request($path, $body = null, $httpMethod = 'GET');

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

} 