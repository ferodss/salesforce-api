<?php
namespace Salesforce\Tests;

use Salesforce\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client($this->getWSDLPath());

        $this->assertInstanceOf('Salesforce\HttpClient\HttpClient', $client->getHttpClient());
    }

    public function testShouldPassHttpClientInterfaceToConstructor()
    {
        $client = new Client($this->getWSDLPath(), $this->getHttpClientMock());

        $this->assertInstanceOf('Salesforce\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    public function testShouldNotHaveToSetSoapClient()
    {
        $client = new Client($this->getWSDLPath(), $this->getHttpClientMock());

        $this->assertInstanceOf('Salesforce\Soap\SoapClientInterface', $client->getSoapClient());
    }

    public function testShouldBeAbletoSetSoapClient()
    {
        $client = new Client($this->getWSDLPath(), $this->getHttpClientMock());
        $client->setSoapClient($this->getSoapClientMock());

        $this->assertInstanceOf('Salesforce\Soap\SoapClientInterface', $client->getSoapClient());
    }

    public function testShouldBeAuthenticatorProxy()
    {
        $login    = 'foo@bar.com';
        $password = '123foobar';
        $token    = 'xpto321';

        $httpClient = $this->getHttpClientMock();

        $soapClient = $this->getSoapClientMock();
        $soapClient->expects($this->once())
            ->method('authenticate')
            ->with($login, $password, $token);

        $client = new Client($this->getWSDLPath(), $httpClient);
        $client->setSoapClient($soapClient);

        $client->authenticate($login, $password, $token);
    }

    public function getHttpClientMock()
    {
        $methods = [
            'setOption', 'getOption', 'authenticate'
        ];

        return $this->getMock('Salesforce\HttpClient\HttpClientInterface', $methods);
    }

    public function getSoapClientMock()
    {
        $methods = [
            'authenticate'
        ];

        return $this->getMockBuilder('Salesforce\Soap\SoapClientInterface')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->getWSDLPath()])
            ->getMock();
    }

    public function getWSDLPath()
    {
        return __DIR__ . '/Fixtures/sandbox.enterprise.wsdl.xml';
    }

} 