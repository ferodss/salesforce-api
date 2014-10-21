<?php
namespace Salesforce\HttpClient\Message;

use Guzzle\Http\Message\Response;

/**
 * Class ResponseMediator
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class ResponseMediator
{

    /**
     * @param Response $response
     * @return \SimpleXMLElement
     */
    public static function getContent(Response $response)
    {
        return $response->xml();
    }

} 