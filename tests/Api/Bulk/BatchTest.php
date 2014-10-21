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

    public function testShouldBeAbleToSetBatchApiLimit()
    {
        $batch = new Batch();
        $batch->setBatchSizeLimit(10);

        $this->assertEquals(10, $batch->getBatchSizeLimit());
    }

    public function testShoulBeInBatchApiLimit()
    {
        $batch = new Batch();
        $batch->setBatchSizeLimit(5);

        for ($i = 0; $i < 3; $i++) {
            $batch->addObject($this->getObjectMock());
        }

        $this->assertTrue($batch->isInApiLimit());
    }

    public function testShoulNotBeInBatchApiLimit()
    {
        $batch = new Batch();
        $batch->setBatchSizeLimit(4);

        for ($i = 0; $i < 5; $i++) {
            $batch->addObject($this->getObjectMock());
        }

        $this->assertFalse($batch->isInApiLimit());
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
            ->willReturn(array('Name' => 'FooBar'));

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

    public function testShouldLoadDataFromXml()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
            <batchInfo xmlns="http://www.force.com/2009/06/asyncapi/dataload">
                <id>751x00000000079AAA</id>
                <state>Queued</state>
            </batchInfo>
        ');

        $batch = new Batch();
        $batch->fromXml($xml);

        $this->assertEquals('751x00000000079AAA', $batch->getId());
        $this->assertEquals('Queued', $batch->getState());
    }

    protected function getObjectMock()
    {
        return $this->getMockBuilder('Salesforce\Objects\AbstractObject')
            ->setMethods(array('asArray', 'getObjectType'))
            ->getMock();
    }

}
 