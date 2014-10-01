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
} 