<?php
namespace Salesforce\Tests\Api\Bulk;

use Salesforce\Api\Bulk\Batch;

class BatchTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeAbleToSetDataOnConstructor()
    {
        $data = ['name' => 'Foo Bar'];
        $batch = new Batch($data);

        $this->assertEquals($data, $batch->getData());
    }

    public function testShouldBeAbleToNotSetDataOnConstructor()
    {
        $batch = new Batch();

        $this->assertEmpty($batch->getData());
    }

    public function testShouldBeAbleToSetDataAfterConstructor()
    {
        $data = ['name' => 'Foo Bar'];

        $batch = new Batch();
        $batch->setData($data);

        $this->assertEquals($data, $batch->getData());
    }

}
 