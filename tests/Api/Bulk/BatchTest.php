<?php
namespace Salesforce\Tests\Api\Bulk;

use Salesforce\Api\Bulk\Batch;

class BatchTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldImplementsXMLSerializable()
    {
        $batch = new Batch();

        $this->assertInstanceOf('Salesforce\Api\Bulk\XMLSerializable', $batch);
    }

    public function testShouldBeAbleToNotSetDataOnConstructor()
    {
        $batch = new Batch();

        $this->assertEmpty($batch->getData());
    }

    public function testShouldBeAbleToAddData()
    {
        $data = $this->getMock('Salesforce\Api\Bulk\Batch\BatchData');

        $batch = new Batch();
        $batch->addData($data);

        $batchData = $batch->getData();

        $this->assertEquals(1, count($batchData));
        $this->assertEquals($data, $batchData[0]);
    }

    public function testShouldGetAXMLString()
    {
        $batch = new Batch();
        $xml = $batch->asXML();

        $this->assertTrue(is_string($xml));
    }

    public function testShouldGetAXmlStringWithBatchData()
    {
        $data = $this->getMock('Salesforce\Api\Bulk\Batch\BatchData');
        $data->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(['customerName' => 'Xpto']));

        $batch = new Batch();
        $batch->addData($data);

        $xml = $batch->asXML();
        $expectedXml = '<?xml version="1.0"?>
            <sObjects xmlns="http://www.force.com/2009/06/asyncapi/dataload">
                <sObject><customerName>Xpto</customerName></sObject>
            </sObjects>
        ';

        $this->assertXmlStringEqualsXmlString($expectedXml, $xml);
    }

}
 