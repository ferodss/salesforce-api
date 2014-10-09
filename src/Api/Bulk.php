<?php
namespace Salesforce\Api;

use Salesforce\Client;
use Salesforce\Api\Bulk\Job;
use Salesforce\HttpClient\Message\ResponseMediator;

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
     * @var \Salesforce\HttpClient\HttpClientInterface
     */
    protected $httpClient;

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
        $this->httpClient = $client->getHttpClient();
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

        if (! ($this->job instanceof Job)) {
            throw new \LogicException('You must set a Job for this bulk');
        }

        $this->httpClient->setHeaders($this->client->getRestAuthorizationHeader());

        $this->flushJob();
        $this->flushBatches();
    }

    /**
     * Flush the Job
     *
     * @TODO Add validation before send request
     *
     * @return void
     */
    protected function flushJob()
    {
        switch ($this->job->getOperation()) {
            case Job::OPERATION_INSERT:
            case Job::OPERATION_UPSERT:
                $response = $this->httpClient->post('job', $this->job->asXML());
                break;
        }

        $response = ResponseMediator::getContent($response);
        $this->job->fromXml($response);
    }

    /**
     * Flush all job batches
     *
     * @return void
     */
    protected function flushBatches()
    {
        $batches = $this->job->getBatches();
        foreach ($batches as $i => $batch) {
            $response = $this->httpClient->post("job/{$this->job->getId()}/batch", $batch->asXML());
            $response = ResponseMediator::getContent($response);

            // @TODO Parse Batch create result to Batch object
            $batches[$i]->setId($response->id);
        }
    }

}