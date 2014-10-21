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
     * XML representation of this entity
     *
     * @var \SimpleXMLElement
     */
    protected $xml;

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
                call_user_func(array($this, $method), (string) $xml->{$attr});
            }
        }
    }

    /**
     * Remove empty fields to allow API to parse correctly
     *
     * @return void
     */
    protected function clearEmptyXMLData()
    {
        $emptyFields = array();
        foreach ($this->xml as $field => $value) {
            if ($value == '') {
                $emptyFields[] = $field;
            }
        }

        foreach ($emptyFields as $field) {
            unset($this->xml->{$field});
        }
    }

}