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
        $client = $this->getClient();

        $this->assertInstanceOf('Salesforce\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    public function testShouldNotHaveToSetSoapClient()
    {
        $client = $this->getClient();

        $this->assertInstanceOf('Salesforce\Soap\SoapClientInterface', $client->getSoapClient());
    }

    public function testShouldBeAbletoSetSoapClient()
    {
        $client = $this->getClient();
        $client->setSoapClient($this->getSoapClientMock());

        $this->assertInstanceOf('Salesforce\Soap\SoapClientInterface', $client->getSoapClient());
    }

    /**
     * @dataProvider apiObjectsDataProvider
     */
    public function testSouldBeAbleToGetApiObjects($apiName, $instanceOf)
    {
        $client = $this->getClient();
        $api = $client->api($apiName);

        $this->assertInstanceOf($instanceOf, $api);
    }

    public function apiObjectsDataProvider()
    {
        return array(
            array('bulk', 'Salesforce\Api\Bulk'),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowsExceptionOnGetInvalidApi()
    {
        $client = $this->getClient();
        $api = $client->api('FooApi');
    }

    public function testShouldBeAuthenticatorProxy()
    {
        $login    = 'foo@bar.com';
        $password = '123foobar';
        $token    = 'xpto321';

        $httpClient = $this->getHttpClientMock();

        $loginResult = $this->getLoginResultMock();
        $loginResult->method('getServerUrl')
            ->willReturn('https://cs21.salesforce.com/services/Soap/c/32.0/');

        $soapClient = $this->getSoapClientMock();
        $soapClient->expects($this->once())
            ->method('authenticate')
            ->with($login, $password, $token)
            ->willReturn($loginResult);

        $client = new Client($this->getWSDLPath(), $httpClient);
        $client->setSoapClient($soapClient);

        $client->authenticate($login, $password, $token);
    }

    public function testShouldNotBeAuthenticated()
    {
        $client = $this->getClient();

        $this->assertFalse($client->isAuthenticated());
    }

    public function testShouldBeAuthenticated()
    {
        $login    = 'foo@bar.com';
        $password = '123foobar';
        $token    = 'xpto321';

        $httpClient = $this->getHttpClientMock();

        $loginResult = $this->getLoginResultMock();
        $loginResult->method('getServerUrl')
            ->willReturn('https://cs21.salesforce.com/services/Soap/c/32.0/');

        $soapClient = $this->getSoapClientMock();
        $soapClient->expects($this->once())
            ->method('authenticate')
            ->with($login, $password, $token)
            ->willReturn($loginResult);

        $client = new Client($this->getWSDLPath(), $httpClient);
        $client->setSoapClient($soapClient);

        $client->authenticate($login, $password, $token);

        $this->assertTrue($client->isAuthenticated());
    }

    public function getHttpClientMock()
    {
        $methods = array(
            'post', 'request', 'setOption', 'getOption', 'setHeaders', 'getHeaders',
        );

        return $this->getMock('Salesforce\HttpClient\HttpClientInterface', $methods);
    }

    public function getSoapClientMock()
    {
        $methods = array('authenticate', 'setLocation');

        return $this->getMockBuilder('Salesforce\Soap\SoapClientInterface')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->setConstructorArgs(array($this->getWSDLPath()))
            ->getMock();
    }

    public function getLoginResultMock()
    {
        $methods = array('getServerUrl', 'getSessionId');

        return $this->getMockBuilder('Salesforce\Soap\Result\LoginResult')
            ->setMethods($methods)
            ->getMock();
    }

    public function getWSDLPath()
    {
        return __DIR__ . '/Fixtures/sandbox.enterprise.wsdl.xml';
    }

    protected function getClient()
    {
        return new Client($this->getWSDLPath(), $this->getHttpClientMock());
    }

} 