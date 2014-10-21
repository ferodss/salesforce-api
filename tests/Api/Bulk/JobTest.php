<?php
namespace Salesforce\Tests\Api\Bulk;

use Salesforce\Api\Bulk\Job;

class JobTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeXmlEntity()
    {
        $job = new Job('Account');

        $this->assertInstanceOf('Salesforce\Api\Bulk\XmlEntity', $job);
        $this->assertInstanceOf('Salesforce\Api\Bulk\XmlSerializable', $job);
    }

    public function testShouldHaveToSetObjectOnConstructor()
    {
        $object = 'Account';
        $job = new Job($object);

        $this->assertEquals($object, $job->getObject());
    }

    /**
     * @dataProvider operationDataProvider
     */
    public function testShouldSetValidOperation($operation)
    {
        $job = new Job('Account');
        $job->setOperation($operation);

        $this->assertEquals($operation, $job->getOperation());
    }

    public function operationDataProvider()
    {
        return array(
            array(Job::OPERATION_INSERT),
            array(Job::OPERATION_UPSERT),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsExceptionWithInvalidOperation()
    {
        $job = new Job('Account');
        $job->setOperation('foooooooo');
    }

    /**
     * @dataProvider jobStatesDataProvider
     */
    public function testShoulBeAbleToSetState($state)
    {
        $job = new Job('Account');
        $job->setState($state);

        $this->assertEquals($state, $job->getState());
    }

    public function jobStatesDataProvider()
    {
        return array(
            array('Open'),
            array('Close'),
            array('Aborted'),
            array('Failed'),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsExceptionWithInvalidState()
    {
        $job = new Job('Account');
        $job->setState('SomeInvalidState');
    }

    public function testShoulBeAbleToSetContentType()
    {
        $job = new Job('Account');
        $job->setContentType(Job::CONTENT_TYPE_XML);

        $this->assertEquals(Job::CONTENT_TYPE_XML, $job->getContentType());
    }

    public function testShouldHaveADefaultContentType()
    {
        $job = new Job('Account');

        $this->assertNotEmpty($job->getContentType());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsExceptionWithInvalidContentType()
    {
        $job = new Job('Account');
        $job->setContentType('SomeInvalidContentType');
    }

    public function testShouldCreateBatchOnCreateJob()
    {
        $job = new Job('Account');

        $this->assertNotEmpty($job->getBatches());
    }

    public function testShouldBeAbleToAddObject()
    {
        $account = $this->getObjectMock();
        $account->expects($this->once())
            ->method('getObjectType')
            ->willReturn('Account');

        $job = new Job('Account');
        $job->addObject($account);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsExceptionOnAddWrongObjectType()
    {
        $account = $this->getObjectMock();
        $account->expects($this->exactly(2))
            ->method('getObjectType')
            ->willReturn('Foo');

        $job = new Job('Account');
        $job->addObject($account);
    }

    public function testShouldDivideDataInBatches()
    {
        $job = new Job('Account');

        for ($i = 0; $i < 201; $i++) {
            $object = $this->getObjectMock();
            $object->method('getObjectType')
                ->willReturn('Account');

            $job->addObject($object);
        }

        $this->assertGreaterThan(1, count($job->getBatches()));
        $this->assertEquals(2, count($job->getBatches()));
    }

    public function testShouldGetAXMLString()
    {
        $job = new Job('Account');
        $xml = $job->asXML();

        $this->assertTrue(is_string($xml));
    }

    public function testShouldClearEmptyXMLAttributes()
    {
        $job = new Job('Account');
        $xml = $job->asXML();

        $expectedXml = '<?xml version="1.0"?>
                <jobInfo xmlns="http://www.force.com/2009/06/asyncapi/dataload">
                    <operation>insert</operation>
                    <object>Account</object>
                    <contentType>XML</contentType>
                </jobInfo>
        ';

        $this->assertXmlStringEqualsXmlString($expectedXml, $xml);
    }

    public function testShouldLoadDataFromXml()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
            <jobInfo xmlns="http://www.force.com/2009/06/asyncapi/dataload">
                <id>750D0000000002lIAA</id>
                <operation>insert</operation>
                <object>Account</object>
                <createdById>005D0000001ALVFIA4</createdById>
                <createdDate>2009-04-14T18:15:59.000Z</createdDate>
                <systemModstamp>2009-04-14T18:15:59.000Z</systemModstamp>
                <state>Open</state>
                <contentType>XML</contentType>
            </jobInfo>
        ');

        $job = new Job('Account');
        $job->fromXml($xml);

        $this->assertEquals('750D0000000002lIAA', $job->getId());
        $this->assertEquals('Open', $job->getState());
    }

    public function getBatchMock()
    {
        return $this->getMockBuilder('Salesforce\Api\Bulk\Batch')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getObjectMock()
    {
        return $this->getMockBuilder('Salesforce\Objects\AbstractObject')
            ->setMethods(array('asArray', 'getObjectType'))
            ->getMock();
    }

}
 