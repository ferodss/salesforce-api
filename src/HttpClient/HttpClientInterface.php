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
} 