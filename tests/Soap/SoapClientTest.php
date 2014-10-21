<?php
namespace Salesforce\Tests\Soap;

use Salesforce\Soap\SoapClient;

class SoapClientTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldRecieveSoapClientOnConstructor()
    {
        $soapClient = $this->getSoapClientMock();
        new SoapClient($soapClient);
    }

    public function testShouldImplementsSoapClientInterface()
    {
        $soapClient = $this->getSoapClientMock();
        $client = new SoapClient($soapClient);

        $this->assertInstanceOf('Salesforce\Soap\SoapClientInterface', $client);
    }

    public function testShouldReturnLoginResult()
    {
        $username = 'foo@bar.com';
        $password = '123foobar';
        $token    = 'xpto321';

        $loginResult = $this->getLoginResultMock();

        $soapClient = $this->getSoapClientMock();
        $soapClient->expects($this->once())
            ->method('login')
            ->with(array('username' => $username, 'password' => $password . $token))
            ->willReturn($loginResult);

        $client = new SoapClient($soapClient);
        $result = $client->authenticate($username, $password, $token);

        $this->assertEquals($result, $loginResult->result);
    }

    public function testShouldBeAbleToChangeSoapLocation()
    {
        $location = 'http://foo.com';

        $soapClient = $this->getSoapClientMock();
        $soapClient->expects($this->once())
            ->method('__setLocation')
            ->with($location);

        $client = new SoapClient($soapClient);
        $client->setLocation($location);
    }

    public function getSoapClientMock()
    {
        $methods = array('login', '__setLocation');

        return $this->getMockBuilder('\SoapClient')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }


    public function getLoginResultMock()
    {
        $methods = array('getServerUrl', 'getSessionId');

        $mock = $this->getMockBuilder('Salesforce\Soap\Result\LoginResult')
            ->setMethods($methods)
            ->getMock();

        $result = new \stdClass();
        $result->result = $mock;

        return $result;
    }

}
 