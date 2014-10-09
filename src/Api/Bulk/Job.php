<?php
namespace Salesforce\Api\Bulk;

use Salesforce\Objects\AbstractObject;

/**
 * Bulk API Job class representation
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Job extends XmlEntity
{

    /**
     * Process batches in parallel mode. This is the default value.
     *
     * @var string
     */
    const CONCURRENCY_MODE_PARALLEL = 'Parallel';

    /**
     * Process batches in serial mode
     *
     * @var string
     */
    const CONCURRENCY_MODE_SERIAL = 'Serial';

    /**
     * XML data type
     *
     * @var string
     */
    const CONTENT_TYPE_XML = 'XML';

    /**
     * Operation type insert
     *
     * @var string
     */
    const OPERATION_INSERT = 'insert';

    /**
     * Operation type upsert
     *
     * @var string
     */
    const OPERATION_UPSERT = 'upsert';

    /**
     * @var string
     */
    protected $id;

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
     * The current state of processing for the job
     *
     * @var string
     */
    protected $state;

    /**
     * The concurrency mode for the job
     *
     * @var string
     */
    protected $concurrencyMode;

    /**
     * The content type for the job
     *
     * @var string
     */
    protected $contentType;

    /**
     * The name of the external ID field for an upsert
     *
     * @var string
     */
    protected $externalIdFieldName;

    /**
     * Valid operations
     *
     * @var array
     */
    protected $validOperations = [
        self::OPERATION_INSERT,
        self::OPERATION_UPSERT,
    ];

    /**
     * Valid job states
     *
     * @var array
     */
    protected $validStates = [
        'Open',
        'Close',
        'Aborted',
        'Failed',
    ];

    /**
     * Valid concurrency modes for the job
     *
     * @var array
     */
    protected $validConcurrencyModes = [
        self::CONCURRENCY_MODE_PARALLEL,
        self::CONCURRENCY_MODE_SERIAL,
    ];

    /**
     * @var Batch[]
     */
    protected $batches = [];

    /**
     * Instantiate a new bulk job
     *
     * @param string $object     The object type for the data
     * @param string $operation  The processing operation
     */
    public function __construct($object, $operation = self::OPERATION_INSERT)
    {
        $this->object = $object;
        $this->setOperation($operation);
    }

    /**
     * Set the Job id
     *
     * @param $id
     *
     * @return Job
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the Job id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Set the current state of processing for the job
     *
     * @param string $state
     *
     * @return Job
     *
     * @throws \InvalidArgumentException
     */
    public function setState($state)
    {
        if (! in_array($state, $this->validStates)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" state is not an valid job state',
                $state
            ));
        }

        $this->state = $state;

        return $this;
    }

    /**
     * Get the current state of processing for the job
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the concurrency mode for the job
     *
     * @param string $concurrencyMode
     *
     * @return Job
     *
     * @throws \InvalidArgumentException
     */
    public function setConcurrencyMode($concurrencyMode)
    {
        if (! in_array($concurrencyMode, $this->validConcurrencyModes)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" concurrency mode is not an valid job concurrency mode',
                $concurrencyMode
            ));
        }

        $this->concurrencyMode = $concurrencyMode;

        return $this;
    }

    /**
     * Get the concurrency mode for the job
     *
     * @return string
     */
    public function getConcurrencyMode()
    {
        return $this->concurrencyMode;
    }

    /**
     * Set the content type for the job
     *
     * @param string $contentType
     *
     * @return Job
     */
    public function setContentType($contentType)
    {
        if ($contentType != self::CONTENT_TYPE_XML) {
            throw new \InvalidArgumentException('Only XML data is supported yet');
        }

        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get the content type for the job
     *
     * @return string
     */
    public function getContentType()
    {
        if (empty($this->contentType)) {
            $this->contentType = self::CONTENT_TYPE_XML;
        }

        return $this->contentType;
    }

    /**
     * Set the name of the external ID field for an upsert
     *
     * @param string $externalIdFieldName
     *
     * @return Job
     */
    public function setExternalIdFieldName($externalIdFieldName)
    {
        $this->externalIdFieldName = $externalIdFieldName;

        return $this;
    }

    /**
     * Get the name of the external ID field for an upsert
     *
     * @return string
     */
    public function getExternalIdFieldName()
    {
        return $this->externalIdFieldName;
    }

    /**
     * Get all job batches
     *
     * @return Batch[]
     */
    public function getBatches()
    {
        return $this->batches;
    }

    /**
     * Add an Salesforce object to the Job
     *
     * @param AbstractObject $object
     *
     * @return Job
     *
     * @throws \InvalidArgumentException
     */
    public function addObject(AbstractObject $object)
    {
        if ($this->getObject() != $object->getObjectType()) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Object type \"%s\" don't match with Job object type \"%s\"",
                    $object->getObjectType(),
                    $this->getObject()
                )
            );
        }

        if (empty($this->batches)) {
            $batch = new Batch();
            $batch->addObject($object);

            $this->batches[] = $batch;
        } else {
            $i = count($this->batches) - 1;
            $this->batches[$i]->addObject($object);
        }

        return $this;
    }

    /**
     * Return a XML string representation of the job
     *
     * @return string
     */
    public function asXML()
    {
        $this->xml = new \SimpleXMLElement("<jobInfo xmlns=\"http://www.force.com/2009/06/asyncapi/dataload\"/>");
        $this->xml->id = $this->getId();
        $this->xml->operation = $this->getOperation();
        $this->xml->object = $this->getObject();
        $this->xml->state = $this->getState();
        $this->xml->concurrencyMode = $this->getConcurrencyMode();
        $this->xml->externalIdFieldName = $this->getExternalIdFieldName();
        $this->xml->contentType = $this->getContentType();

        $this->clearEmptyXMLData();

        return $this->xml->asXML();
    }

}