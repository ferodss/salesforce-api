<?php
namespace Salesforce\Api\Bulk;

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
     * @var array
     */
    protected $data = [];

    /**
     * Add batch data to the jobs batch
     *
     * @param array $data
     *
     * @return Batch
     */
    public function addData(array $data)
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * Returns all jobs batches
     *
     * @return array[]
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

        foreach ($this->data as $batchData) {
            $sObject = $xml->addChild('sObject');

            foreach ($batchData as $name => $value) {
                $sObject->addChild($name, $value);
            }
        }

        return $xml->asXML();
    }

} 