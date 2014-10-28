<?php
namespace Salesforce\Plugin;

use Salesforce\Api\Events;
use Salesforce\Event\CreateBatchEvent;
use Salesforce\Event\CreateJobEvent;
use Salesforce\Event\QueryEvent;
use Salesforce\Event\RequestEvent;
use Salesforce\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

/**
 * Plugin to log requests
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class LogRequestsPlugin implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Log each Job create request
     *
     * @param CreateJobEvent $event
     *
     * @return void
     */
    public function onCreateJob(CreateJobEvent $event)
    {
        $this->logger->info(sprintf(
            '[salesforce-api] Creating Job through Bulk API (%s): %s',
            $event->getUrl(),
            $event->getBody()
        ));
    }

    /**
     * Log each Batch create request
     *
     * @param CreateBatchEvent $event
     *
     * @return void
     */
    public function onCreateBatch(CreateBatchEvent $event)
    {
        $this->logger->info(sprintf(
            '[salesforce-api] Creating Job Batch through Bulk API (%s): %s',
            $event->getUrl(),
            $event->getBody()
        ));
    }

    /**
     * Log each Salesforce API response
     *
     * @param ResponseEvent $event
     *
     * @return void
     */
    public function onClientResponse(ResponseEvent $event)
    {
        $this->logger->info(sprintf(
            '[salesforce-api] Response: %s',
            $event->getResponse()
        ));
    }

    /**
     * Log each Query sent to Salesforce API
     *
     * @param QueryEvent $event
     *
     * @return void
     */
    public function onQuery(QueryEvent $event)
    {
        $this->logger->info(sprintf(
            '[salesforce-api] Query (%s): %s',
            $event->getUrl(),
            http_build_query($event->getQueryString())
        ));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CREATE_JOB   => 'onCreateJob',
            Events::CREATE_BATCH => 'onCreateBatch',
            Events::RESPONSE     => 'onClientResponse',
            Events::QUERY        => 'onQuery',
        );
    }

}