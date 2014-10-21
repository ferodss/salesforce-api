<?php
namespace Salesforce\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Represents a request event
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class RequestEvent extends Event
{

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $method;

    /**
     * @param string $url
     * @param string $method
     * @param string $body
     */
    public function __construct($url, $method, $body)
    {
        $this->url = $url;
        $this->method = $method;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

}