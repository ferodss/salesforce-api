<?php
namespace Salesforce\Tests\Soap;

use Salesforce\Soap\SoapClient;

class SoapClientTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldReturnLoginResult()
    {
        $username = 'foo@bar.com';
        $password = '123foobar';
        $token    = 'xpto321';

        $loginResult = $this->getLoginResultMock();

        $soapClient = $this->getSoapClientMock();
        $soapClient->expects($this->once())
            ->method('login')
            ->with(['username' => $username, 'password' => $password . $token])
            ->willReturn($loginResult);

        $client = new SoapClient($soapClient);
        $result = $client->authenticate($username, $password, $token);

        $this->assertEquals($result, $loginResult);
    }

    public function getSoapClientMock()
    {
        $methods = ['login'];

        return $this->getMockBuilder('\SoapClient')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }


    public function getLoginResultMock()
    {
        $methods = [
            'getServerUrl', 'getSessionId',
        ];

        $mock = $this->getMockBuilder('Salesforce\Soap\Result\LoginResult')
            ->setMethods($methods)
            ->getMock();

        $result = new \stdClass();
        $result->result = $mock;

        return $result;
    }

}
 