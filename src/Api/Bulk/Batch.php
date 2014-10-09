<?php
namespace Salesforce\Api\Bulk;

use Salesforce\Objects\AbstractObject;

/**
 * Bulk API Job Batch representation
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Batch extends XmlEntity
{

    /**
     * The Batch ID
     *
     * @var string
     */
    protected $id;

    /**
     * The Batch state
     *
     * @var string
     */
    protected $state;

    /**
     * Batch data
     *
     * @var AbstractObject[]
     */
    protected $data = [];

    /**
     * Set the Batch ID
     *
     * @param string $id
     *
     * @return Batch
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the Batch ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the Batch state
     *
     * @param string $state
     *
     * @return Batch
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

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
        $this->xml = new \SimpleXMLElement("<sObjects xmlns=\"http://www.force.com/2009/06/asyncapi/dataload\"/>");

        foreach ($this->data as $object) {
            $sObject = $this->xml->addChild('sObject');

            foreach ($object->asArray() as $name => $value) {
                if (! empty($value)) {
                    $sObject->addChild($name, $value);
                }
            }
        }

        return $this->xml->asXML();
    }

}