<?php
namespace Salesforce\Api\Bulk;

use Salesforce\Objects\AbstractObject;

/**
 * Bulk API Job Batch representation
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Batch implements XMLSerializable
{

    /**
     * Batch data
     *
     * @var AbstractObject[]
     */
    protected $data = [];

    /**
     * Add batch object data to the jobs batch
     *
     * @param AbstractObject $object
     *
     * @return Batch
     */
    public function addObject(AbstractObject $object)
    {
        $this->data[] = $object;

        return $this;
    }

    /**
     * Returns all jobs batches
     *
     * @return AbstractObject[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return a XML string representation of the job
     *
     * @return string
     */
    public function asXML()
    {
        $xml = new \SimpleXMLElement("<sObjects xmlns=\"http://www.force.com/2009/06/asyncapi/dataload\"/>");

        foreach ($this->data as $object) {
            $sObject = $xml->addChild('sObject');

            foreach ($object->asArray() as $name => $value) {
                $sObject->addChild($name, $value);
            }
        }

        return $xml->asXML();
    }

} 