<?php
namespace Salesforce\Tests\Api\Bulk;

use Salesforce\Api\Bulk\Job;

class JobTest extends \PHPUnit_Framework_TestCase
{

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

}
 