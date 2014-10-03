<?php
namespace Salesforce\Tests\Api\Bulk\Batch;

use Salesforce\Api\Bulk\Batch\BatchData;

class BatchDataTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeAbleToSetData()
    {
        $batchData = new BatchData();
        $batchData->customerName ='Xpto';
    }

    public function testShouldBeAbleToGetData()
    {
        $customerName = 'Xpto';

        $batchData = new BatchData();
        $batchData->customerName =$customerName;

        $this->assertEquals($customerName, $batchData->customerName);
    }

    public function testShouldBeAbleToGetAllData()
    {
        $batchData = new BatchData();
        $batchData->customerName ='Xpto';

        $this->assertNotEmpty($batchData->getData());
    }

}
 