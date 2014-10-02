<?php
namespace Salesforce\Api;

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

}