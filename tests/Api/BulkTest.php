<?php
namespace Salesforce\Tests\Api;

use Salesforce\Api\Bulk;

class BulkTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeAbleToAddAJob()
    {
        $job = $this->getMockBuilder('Salesforce\Api\Bulk\Job')
            ->disableOriginalConstructor()
            ->getMock();

        $bulkApi = new Bulk();
        $bulkApi->setJob($job);

        $this->assertEquals($job, $bulkApi->getJob());
    }

}
 