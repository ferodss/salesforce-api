<?php
namespace Salesforce\Api\Bulk;

/**
 * Bulk API Job class wrapper
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Job
{

    /**
     * The object type for the data being processed
     * All data in a job must be of a single object type
     *
     * @var string
     */
    protected $object;

    /**
     * The processing operation for all the batches in the job
     *
     * @var string
     */
    protected $operation;

    /**
     * Valid operations
     *
     * @var array
     */
    protected $validOperations = [
        'insert',
    ];

    /**
     * Instantiate a new bulk job
     *
     * @param string $object     The object type for the data
     * @param string $operation  The processing operation
     */
    public function __construct($object, $operation = 'insert')
    {
        $this->object = $object;
        $this->setOperation($operation);
    }

    /**
     * Get object type for the data
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set a valid processing operation
     * Throws an InvalidArgumentException when given operation is not valid
     *
     * @param string $operation The processing operation
     *
     * @return Job
     *
     * @throws \InvalidArgumentException
     */
    public function setOperation($operation)
    {
        $operation = strtolower($operation);

        if (! in_array($operation, $this->validOperations)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" operation is not an valid operation',
                $operation
            ));
        }

        $this->operation = $operation;

        return $this;
    }

    /**
     * Get the processing operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }
} 