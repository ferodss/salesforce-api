<?php
namespace Salesforce\Tests\Api;

use Salesforce\Api\ApiFactory;

class ApiFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getApiClassesProvider
     */
    public function testShouldGetApiInstance($apiName, $class)
    {
        $this->assertInstanceOf($class, ApiFactory::getApi($apiName));
    }

    public function getApiClassesProvider()
    {
        return [
            ['bulk', 'Salesforce\Api\Bulk']
        ];
    }

} 