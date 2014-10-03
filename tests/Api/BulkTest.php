<?php
namespace Salesforce\Tests\Api;

use Salesforce\Api\Bulk;

class BulkTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeAbleToCreateAJob()
    {
        $bulkApi = new Bulk();
        $job = $bulkApi->createJob('SomeObject');

        $this->assertInstanceOf('Salesforce\Api\Bulk\Job', $job);
    }

    public function testShouldSetJobOnCreateAJob()
    {
        $bulkApi = new Bulk();
        $job = $bulkApi->createJob('SomeObject');

        $this->assertEquals($job, $bulkApi->getJob());
    }

    public function testShouldBeAbleToAddAJob()
    {
        $job = $this->getMockBuilder('Salesforce\Api\Bulk\Job')
            ->disableOriginalConstructor()
            ->getMock();

        $bulkApi = new Bulk();
        $bulkApi->setJob($job);

        $this->assertEquals($job, $bulkApi->getJob());
    }

    public function testShouldBeAbleToCreateABatch()
    {
        $bulkApi = new Bulk();
        $batch = $bulkApi->createBatch();

        $this->assertInstanceOf('Salesforce\Api\Bulk\Batch', $batch);
    }
}
 