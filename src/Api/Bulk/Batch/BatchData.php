<?php
namespace Salesforce\Api\Bulk\Batch;

use Salesforce\Api\Bulk\XMLSerializable;

/**
 * Represents a Salesforce Bulk API batchs data
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class BatchData
{

    /**
     * @var array
     */
    protected $data =[];

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param  string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (! array_key_exists($name, $this->data)) {
            return null;
        }

        return $this->data[$name];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

} 