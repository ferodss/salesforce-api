<?php
namespace Salesforce\Api\Bulk;

/**
 * Bulk API Job Batch representation
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Batch
{

    /**
     * Batch data
     *
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return Batch
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

} 