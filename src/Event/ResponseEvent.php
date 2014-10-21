<?php
namespace Salesforce\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Represents a response event
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class ResponseEvent extends Event
{

    /**
     * @var RequestEvent
     */
    protected $requestEvent;

    /**
     * @var \SimpleXMLElement
     */
    protected $response;

    /**
     * @param RequestEvent $requestEvent
     * @param mixed        $response
     */
    public function __construct(RequestEvent $requestEvent, \SimpleXMLElement $response)
    {
        $this->requestEvent = $requestEvent;
        $this->response     = $response;
    }

    /**
     * @return RequestEvent
     */
    public function getRequestEvent()
    {
        return $this->requestEvent;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response->asXML();
    }

}