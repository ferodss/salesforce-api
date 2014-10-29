<?php
namespace Salesforce\Tests\Api;

use Salesforce\Api\Bulk;

class BulkTest extends \PHPUnit_Framework_TestCase
{

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $client;

    protected function setUp()
    {
        $this->client = $this->getMockBuilder('Salesforce\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('getHttpClient', 'getServerInstance', 'isAuthenticated'))
            ->getMock();
        $this->client->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($this->getHttpClientMock());
        $this->client->expects($this->once())
            ->method('getServerInstance')
            ->willReturn('cs21');
    }

    public function testShouldBeAbleToCreateAJob()
    {
        $bulkApi = new Bulk($this->client);
        $job = $bulkApi->createJob('Account');

        $this->assertInstanceOf('Salesforce\Api\Bulk\Job', $job);
    }

    public function testShouldSetJobOnCreateAJob()
    {
        $bulkApi = new Bulk($this->client);
        $job = $bulkApi->createJob('Account');

        $this->assertEquals($job, $bulkApi->getJob());
    }

    public function testShouldBeAbleToAddAJob()
    {
        $job = $this->getMockBuilder('Salesforce\Api\Bulk\Job')
            ->disableOriginalConstructor()
            ->getMock();

        $bulkApi = new Bulk($this->client);
        $bulkApi->setJob($job);

        $this->assertEquals($job, $bulkApi->getJob());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testShouldBeAuthenticatedToFlush()
    {
        $bulkApi = new Bulk($this->client);
        $bulkApi->flush();
    }

    /**
     * @expectedException \LogicException
     */
    public function testShouldHaveJobToFlush()
    {
        $this->client->expects($this->once())
            ->method('isAuthenticated')
            ->willReturn(true);

        $bulkApi = new Bulk($this->client);
        $bulkApi->flush();
    }

    public function getHttpClientMock()
    {
        $methods = array(
            'get', 'post', 'request', 'setOption', 'getOption', 'setHeaders', 'getHeaders',
            'setBaseUrl', 'getBaseUrl'
        );

        $mock = $this->getMock('Salesforce\HttpClient\HttpClientInterface', $methods);
        $mock->expects($this->once())
            ->method('setBaseUrl');

        return $mock;
    }

}