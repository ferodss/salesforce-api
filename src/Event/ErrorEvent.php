<?php
namespace Salesforce\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Represents a request error event
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class ErrorEvent extends Event
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
    protected $message;

    /**
     * @param string $url
     * @param string $body
     * @param string $message
     */
    public function __construct($url, $body, $message)
    {
        $this->url = $url;
        $this->body = $body;
        $this->message = $message;
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
    public function getMessage()
    {
        return $this->message;
    }

}