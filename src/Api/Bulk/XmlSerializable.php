<?php
namespace Salesforce\Api\Bulk;

/**
 * Interface XMLSerializable
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
interface XmlSerializable
{

    /**
     * Return a well-formed XML string based on object data
     *
     * @return string
     */
    public function asXML();

    /**
     * Updates object attributes by given xml
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
    public function fromXml(\SimpleXMLElement $xml);

}