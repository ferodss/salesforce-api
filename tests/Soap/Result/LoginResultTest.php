<?php
namespace Salesforce\Tests\Soap\Result;

use Salesforce\Soap\Result\LoginResult;

class LoginResultTest extends \PHPUnit_Framework_TestCase
{

    /** @var LoginResult */
    protected $testClass;
    protected $reflection;

    protected function setUp()
    {
        $this->testClass = new LoginResult();
        $this->reflection = new \ReflectionClass($this->testClass);
    }

    /**
     * @dataProvider loginInformationDataProvider
     */
    public function testShouldGetLoginInformation($property, $value)
    {
        $this->setProperty($property, $value);

        $getMethod = 'get' . ucfirst($property);
        $this->assertEquals($value, $this->testClass->{$getMethod}());
    }

    public function loginInformationDataProvider()
    {
        return array(
            array('metadataServerUrl', 'https://na1-api.salesforce.com/services/Soap/m/32.0'),
            array('passwordExpired', ''),
            array('sandbox', 1),
            array('serverUrl', 'https://na1-api.salesforce.com/services/Soap/m/32.0'),
            array('sessionId', uniqid()),
            array('userId', uniqid()),
            array('userInfo', new \stdClass()),
        );
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testShouldThrowsExceptionGetServerInstanceWithoutSet()
    {
        $this->testClass->getServerInstance();
    }

    public function testShouldGetServcerInstance()
    {
        $serverInstance = 'na1-api';
        $this->setProperty('serverUrl', "https://{$serverInstance}.salesforce.com/services/Soap/m/32.0");

        $this->assertEquals($serverInstance, $this->testClass->getServerInstance());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testShouldThrowsExceptionGetServerInstanceWithInvalidServerUrl()
    {
        $this->setProperty('serverUrl', "https://foo.bar.com");

        $this->testClass->getServerInstance();
    }


    protected function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->testClass, $value);
    }

}
 