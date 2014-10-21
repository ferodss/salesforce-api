<?php
namespace Salesforce\Event;

/**
 * Event dispatched when a Bulk Job is created
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class CreateJobEvent extends RequestEvent
{

    /**
     * @param string $url
     * @param string $body
     */
    public function __construct($url, $body)
    {
        parent::__construct($url, 'POST', $body);
    }

}