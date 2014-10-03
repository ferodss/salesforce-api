<?php
namespace Salesforce\Api\Bulk;

/**
 * Interface XMLSerializable
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
interface XMLSerializable
{

    /**
     * Return a well-formed XML string based on object data
     *
     * @return string
     */
    public function asXML();

} 