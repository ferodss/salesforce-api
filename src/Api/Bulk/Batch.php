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
     * Maximum number of records that may be updated or created per call
     *
     * @see https://developer.salesforce.com/docs/atlas.en-us.192.0.api_asynch.meta/api_asynch/asynch_api_concepts_limits.htm
     *
     * @var int
     */
    protected $batchSizeLimit = 200;

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
     * Set maximum number of records that may be updated or created per call
     *
     * @param int $batchSizeLimit
     */
    public function setBatchSizeLimit($batchSizeLimit)
    {
        $this->batchSizeLimit = $batchSizeLimit;

        return $this;
    }

    /**
     * Get maximum number of records that may be updated or created per call
     *
     * @return int
     */
    public function getBatchSizeLimit()
    {
        return $this->batchSizeLimit;
    }

    /**
     * Check if this Batch is in size limit by Bulk API
     *
     * @return bool
     */
    public function isInApiLimit()
    {
        return (count($this->data) <= $this->batchSizeLimit);
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