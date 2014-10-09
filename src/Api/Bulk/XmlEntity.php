<?php
namespace Salesforce\Api\Bulk;

/**
 * Abstract Xml entity
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
abstract class XmlEntity implements XmlSerializable
{

    /**
     * {@inheritDoc}
     */
    abstract public function asXML();

    /**
     * Updates Job information by given xml
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
    public function fromXml(\SimpleXMLElement $xml)
    {
        foreach ($xml as $attr => $node) {
            $method = 'set' . ucfirst($attr);

            if (method_exists($this, $method)) {
                call_user_func([$this, $method], (string) $xml->{$attr});
            }
        }
    }

}