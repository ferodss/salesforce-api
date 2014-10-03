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
        $object = 'SomeObject';
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
        $job = new Job('SomeObject');
        $job->setOperation('foooooooo');
    }

    /**
     * @dataProvider jobStatesDataProvider
     */
    public function testShoulBeAbleToSetState($state)
    {
        $job = new Job('SomeObject');
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
        $job = new Job('SomeObject');
        $job->setState('SomeInvalidState');
    }

    /**
     * @dataProvider jobConcurrencyModeDataProvider
     */
    public function testShoulBeAbleToSetConcurrencyMode($concurrencyMode)
    {
        $job = new Job('SomeObject');
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
        $job = new Job('SomeObject');

        $this->assertNotEmpty($job->getConcurrencyMode());
    }

    public function testShoulBeAbleToSetContentType()
    {
        $job = new Job('SomeObject');
        $job->setContentType(Job::CONTENT_TYPE_XML);

        $this->assertEquals(Job::CONTENT_TYPE_XML, $job->getContentType());
    }

    public function testShouldHaveADefaultContentType()
    {
        $job = new Job('SomeObject');

        $this->assertNotEmpty($job->getContentType());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsExceptionWithInvalidContentType()
    {
        $job = new Job('SomeObject');
        $job->setContentType('SomeInvalidContentType');
    }

    public function testBatchesShouldBeEmptyOnCreateAJob()
    {
        $job = new Job('SomeObject');

        $this->assertEmpty($job->getBatches());
    }

    public function testShouldBeAbleToAddBatch()
    {
        $batch = $this->getBatchMock();

        $job = new Job('SomeObject');
        $job->addBatch($batch);

        $this->assertNotEmpty($job->getBatches());
    }

    public function testShouldBeAbleToAddMultipleBatches()
    {
        $batch1 = $this->getBatchMock();
        $batch2 = $this->getBatchMock();

        $job = new Job('SomeObject');
        $job->addBatch($batch1)
            ->addBatch($batch2);

        $this->assertEquals(2, count($job->getBatches()));
    }

    public function testShouldGetAXMLString()
    {
        $job = new Job('SomeObject');
        $xml = $job->asXML();

        $this->assertTrue(is_string($xml));
    }

    public function testShouldClearEmptyXMLAttributes()
    {
        $job = new Job('SomeObject');
        $xml = $job->asXML();

        $expectedXml = '<?xml version="1.0"?><jobInfo xmlns="http://www.force.com/2009/06/asyncapi/dataload"><operation>insert</operation><object>SomeObject</object><concurrencyMode>Parallel</concurrencyMode></jobInfo>';

        $this->assertXmlStringEqualsXmlString($expectedXml, $xml);
    }

    public function getBatchMock()
    {
        return $this->getMockBuilder('Salesforce\Api\Bulk\Batch')
            ->disableOriginalConstructor()
            ->getMock();
    }


}
 