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
        $response = $httpClient->post($path, $body);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShouldDoCustomRequest()
    {
        $path = '/some/path';
        $body = 'a = b';

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient([], $client);
        $response = $httpClient->request($path, $body, 'HEAD');

        $this->assertEquals(200, $response->getStatusCode());
    }

    protected function getBrowserMock()
    {
        $client = new \GuzzleHttp\Client(['base_url' => 'http://123.com/']);
        $subscriber = new \GuzzleHttp\Subscriber\Mock([
            new \GuzzleHttp\Message\Response(200, ['X-Foo' => 'Bar']),
        ]);

        $client->getEmitter()->attach($subscriber);

        return $client;
    }
} 