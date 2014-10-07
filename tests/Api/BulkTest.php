<?php
namespace Salesforce\Tests\Api;

use Salesforce\Api\Bulk;

class BulkTest extends \PHPUnit_Framework_TestCase
{

    protected $client;

    protected function setUp()
    {
        $this->client = $this->getMockBuilder('Salesforce\Client')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testShouldBeAbleToCreateAJob()
    {
        $bulkApi = new Bulk($this->client);
        $job = $bulkApi->createJob('Account');

        $this->assertInstanceOf('Salesforce\Api\Bulk\Job', $job);
    }

    public function testShouldSetJobOnCreateAJob()
    {
        $bulkApi = new Bulk($this->client);
        $job = $bulkApi->createJob('Account');

        $this->assertEquals($job, $bulkApi->getJob());
    }

    public function testShouldBeAbleToAddAJob()
    {
        $job = $this->getMockBuilder('Salesforce\Api\Bulk\Job')
            ->disableOriginalConstructor()
            ->getMock();

        $bulkApi = new Bulk($this->client);
        $bulkApi->setJob($job);

        $this->assertEquals($job, $bulkApi->getJob());
    }

}
 