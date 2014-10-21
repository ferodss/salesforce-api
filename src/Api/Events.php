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
     *
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

}