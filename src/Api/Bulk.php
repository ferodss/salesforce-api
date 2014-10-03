<?php
namespace Salesforce\Api;

use Salesforce\Api\Bulk\Batch;
use Salesforce\Api\Bulk\Job;

/**
 * Bulk API wrapper
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Bulk
{

    /**
     * Current bulk job
     *
     * @var Job
     */
    protected $job;

    /**
     * Create a new job and set it as bulk's job
     *
     * @param string $object The object type for the data
     *
     * @return Job
     */
    public function createJob($object)
    {
        $this->setJob(new Job($object));

        return $this->getJob();
    }

    /**
     * Set current bulk job
     *
     * @param Job $job
     *
     * @return Bulk
     */
    public function setJob(Job $job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get current bulk job
     *
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Create a new batch
     *
     * @return Batch
     */
    public function createBatch()
    {
        return new Batch();
    }

}