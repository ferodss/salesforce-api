<?php
namespace Salesforce\Tests\HttpClient;

use Salesforce\HttpClient\HttpClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldBeAbleToPassOptionsToConstructor()
    {
        $options = ['timeout' => 60];
        $httpClient = new HttpClient($options);

        $this->assertEquals($options['timeout'], $httpClient->getOption('timeout'));
    }

    public function testShouldBeAbleToSetOption()
    {
        $httpClient = new HttpClient();
        $httpClient->setOption('timeout', 60);

        $this->assertEquals(60, $httpClient->getOption('timeout'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowExceptionWhenSetInvalidOption()
    {
        $httpClient = new HttpClient();
        $httpClient->setOption('foobar', 1);
    }

    public function testShouldBeAbleAddHeader()
    {
        $httpClient = new HttpClient();
        $httpClient->setHeaders(['Foo' => 'Bar']);

        $headers = $httpClient->getHeaders();

        $this->assertEquals('Bar', $headers['Foo']);
    }

    public function testShouldDoPOSTRequest()
    {
        $path = '/some/path';
        $body = 'a = b';

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient([], $client);
        $httpClient->post($path, $body);
    }

    public function testShouldDoCustomRequest()
    {
        $path = '/some/path';
        $body = 'a = b';

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient([], $client);
        $httpClient->request($path, $body, 'HEAD');
    }

    protected function getBrowserMock()
    {
        $clientMock = $this->getMock('Guzzle\Http\Client', array(
             'send', 'createRequest'
        ));

        $clientMock->expects($this->any())
            ->method('createRequest')
            ->will($this->returnValue($this->getMock('Guzzle\Http\Message\Request', array(), array('GET', 'some'))));

        return $clientMock;
    }
} 