<?php
namespace Salesforce\Api;

/**
 * Events
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
final class Events
{

    /**
     * The salesforce.bulk.create_job event is thrown each time a create job request
     * is sent to Salesforce Bulk API
     *
     * The event listener receives an Salesforce\Event\CreateJobEvent instance
     *
     * @var string
     */
    const CREATE_JOB = 'salesforce.bulk.create_job';

    /**
     * The salesforce.bulk.create_batch event is thrown each time a job batch request
     * is sent to Salesforce Bulk API
     *
     * The event listener receives an Salesforce\Event\CreateBatchEvent instance
     *
     * @var string
     */
    const CREATE_BATCH = 'salesforce.bulk.create_batch';

    /**
     * The salesforce.response event is thrown each time the API receives
     * a request response from Salesforce API
     *
     * The event listener receives an Salesforce\Event\ResponseEvent instance
     *
     * @var string
     */
    const RESPONSE = 'salesforce.response';

    /**
     * The salesforce.query event is thrown each time a Query request
     * is sent to Salesforce API
     *
     * The event listener receives a Salesforce\Event\RequestEvent instance
     */
    const QUERY = 'salesforce.query';

}