<?php
namespace Salesforce\Tests\Api\Bulk;

use Salesforce\Api\Bulk\Batch;

class BatchTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeXmlEntity()
    {
        $batch = new Batch();

        $this->assertInstanceOf('Salesforce\Api\Bulk\XmlEntity', $batch);
        $this->assertInstanceOf('Salesforce\Api\Bulk\XMLSerializable', $batch);
    }

    public function testShouldBeAbleToNotSetDataOnConstructor()
    {
        $batch = new Batch();

        $this->assertEmpty($batch->getData());
    }

    public function testShouldBeAbleToAddObject()
    {
        $object = $this->getObjectMock();

        $batch = new Batch();
        $batch->addObject($object);

        $batchData = $batch->getData();

        $this->assertEquals(1, count($batchData));
        $this->assertEquals($object, $batchData[0]);
    }

    public function testShouldGetAXMLString()
    {
        $batch = new Batch();
        $xml = $batch->asXML();

        $this->assertTrue(is_string($xml));
    }

    public function testShouldGetAXmlStringWithBatchData()
    {
        $object = $this->getObjectMock();
        $object->expects(($this->once()))
            ->method('asArray')
            ->willReturn(['Name' => 'FooBar']);

        $batch = new Batch();
        $batch->addObject($object);

        $xml = $batch->asXML();
        $expectedXml = '<?xml version="1.0"?>
            <sObjects xmlns="http://www.force.com/2009/06/asyncapi/dataload">
                <sObject><Name>FooBar</Name></sObject>
            </sObjects>
        ';

        $this->assertXmlStringEqualsXmlString($expectedXml, $xml);
    }

    protected function getObjectMock()
    {
        return $this->getMockBuilder('Salesforce\Objects\AbstractObject')
            ->setMethods(['asArray', 'getObjectType'])
            ->getMock();
    }

}
 