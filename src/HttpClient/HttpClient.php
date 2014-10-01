<?php
namespace Salesforce\HttpClient;

/**
 * Perform requests on Salesforce API
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class HttpClient implements HttpClientInterface
{

    protected $options = [
        'timeout'  => 10,
    ];

    /**
     * Instantiate a new HttpClient
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->options, $options);
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
} 