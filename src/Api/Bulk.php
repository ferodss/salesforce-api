<?php
namespace Salesforce\Api;

use Salesforce\Client;
use Salesforce\Api\Bulk\Job;

/**
 * Salesforce Bulk API wrapper
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Bulk
{

    /**
     * Salesforce API client
     *
     * @var Client
     */
    protected $client;

    /**
     * Current bulk job
     *
     * @var Job
     */
    protected $job;

    /**
     * Instantiate a new Salesforce Bulk API
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

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

        return $this->job;
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
     * Flush the Job to the Salesforce
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    public function flush()
    {
        if (! $this->client->isAuthenticated()) {
            throw new \RuntimeException('You must be authenticated!');
        }

        $httpClient = $this->client->getHttpClient();
        $httpClient->setHeaders($this->client->getRestAuthorizationHeader());

        // Flush the Job
        // @TODO Parse Job create result to Job object
        switch ($this->job->getOperation()) {
            case Job::OPERATION_INSERT:
                $httpClient->post('job', $this->job->asXML());
                break;
        }

        // Flush all job batches
        foreach ($this->job->getBatches() as $batch) {
            $httpClient->post("job/{$this->job->getId()}/batch", $batch->asXML());
        }
    }

}