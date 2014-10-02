<?php
namespace Salesforce\Tests\Soap;

use Salesforce\Soap\SoapClientFactory;

class SoapClientFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldCreateASoapClientObject()
    {
        $soapClient = SoapClientFactory::factory($this->getWSDLPath());

        $this->assertInstanceOf('Salesforce\Soap\SoapClientInterface', $soapClient);
    }

    public function getWSDLPath()
    {
        return __DIR__ . '/../Fixtures/sandbox.enterprise.wsdl.xml';
    }

}
 