<?php
namespace Salesforce\Tests;

use Salesforce\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('Salesforce\HttpClient\HttpClient', $client->getHttpClient());
    }

    public function testShouldPassHttpClientInterfaceToConstructor()
    {
        $client = new Client($this->getHttpClientMock());

        $this->assertInstanceOf('Salesforce\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    public function getHttpClientMock()
    {
        $methods = [];

        return $this->getMock('Salesforce\HttpClient\HttpClientInterface', $methods);
    }
} 