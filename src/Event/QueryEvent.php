<?php
namespace Salesforce\Event;

/**
 * Event dispatched when a Query is sent to Salesforce API
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class QueryEvent extends RequestEvent
{

    /**
     * @var array
     */
    protected $queryString;

    /**
     * @param string $url
     * @param array $queryString
     */
    public function __construct($url, $queryString)
    {
        parent::__construct($url, 'POST', null);
        $this->queryString = $queryString;
    }

    /**
     * @return array
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

}