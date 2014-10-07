<?php
namespace Salesforce\Tests\Api\Bulk;

use Salesforce\Api\Bulk\Job;

class JobTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldImplementsXMLSerializable()
    {
        $job = new Job('Account');

        $this->assertInstanceOf('Salesforce\Api\Bulk\XMLSerializable', $job);
    }

    public function testShouldHaveToSetObjectOnConstructor()
    {
        $object = 'Account';
        $job = new Job($object);

        $this->assertEquals($object, $job->getObject());
    }

    public function testShouldSetValidOperation()
    {
        $job = new Job('Account');
        $job->setOperation($operation = 'insert');

        $this->assertEquals($operation, $job->getOperation());
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
        return [
            ['Open'],
            ['Close'],
            ['Aborted'],
            ['Failed'],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsExceptionWithInvalidState()
    {
        $job = new Job('Account');
        $job->setState('SomeInvalidState');
    }

    /**
     * @dataProvider jobConcurrencyModeDataProvider
     */
    public function testShouldBeAbleToSetConcurrencyMode($concurrencyMode)
    {
        $job = new Job('Account');
        $job->setConcurrencyMode($concurrencyMode);

        $this->assertEquals($concurrencyMode, $job->getConcurrencyMode());
    }

    public function jobConcurrencyModeDataProvider()
    {
        return [
            [Job::CONCURRENCY_MODE_PARALLEL],
            [Job::CONCURRENCY_MODE_SERIAL],
        ];
    }

    public function testShouldHaveADefaultConcurrencyMode()
    {
        $job = new Job('Account');

        $this->assertNotEmpty($job->getConcurrencyMode());
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

    public function testBatchesShouldBeEmptyOnCreateAJob()
    {
        $job = new Job('Account');

        $this->assertEmpty($job->getBatches());
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

    public function testShouldHaveBatch()
    {
        $account = $this->getObjectMock();
        $account->expects($this->once())
            ->method('getObjectType')
            ->willReturn('Account');

        $job = new Job('Account');
        $job->addObject($account);

        $this->assertNotEmpty($job->getBatches());
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
                    <concurrencyMode>Parallel</concurrencyMode>
                    <contentType>XML</contentType>
                </jobInfo>
        ';

        $this->assertXmlStringEqualsXmlString($expectedXml, $xml);
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
            ->setMethods(['asArray', 'getObjectType'])
            ->getMock();
    }

}
 