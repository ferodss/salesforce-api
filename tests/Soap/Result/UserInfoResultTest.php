<?php
namespace Salesforce\Tests\Soap\Result;

use Salesforce\Soap\Result\UserInfoResult;

class UserInfoResultTest extends \PHPUnit_Framework_TestCase
{

    /** @var UserInfoResult */
    protected $testClass;
    protected $reflection;

    protected function setUp()
    {
        $this->testClass = new UserInfoResult();
        $this->reflection = new \ReflectionClass($this->testClass);
    }

    /**
     * @dataProvider userInfoDataProvider
     */
    public function testShouldGetUserInfo($property, $value)
    {
        $this->setProperty($property, $value);

        $getMethod = 'get' . ucfirst($property);
        $this->assertEquals($value, $this->testClass->{$getMethod}());
    }

    public function userInfoDataProvider()
    {
        return array(
            array('accessibilityMode', false),
            array('currencySymbol', '$'),
            array('orgAttachmentFileSizeLimit', '5242880'),
            array('orgDefaultCurrencyIsoCode', 'USD'),
            array('orgDisallowHtmlAttachments', false),
            array('orgHasPersonAccounts', false),
            array('organizationId', '00Do0000000biPkEAI'),
            array('organizationMultiCurrency', 'false'),
            array('organizationName', 'FooBar Company'),
            array('profileId', '00eo0000000x7M5AAI'),
            array('roleId', null),
            array('sessionSecondsValid', 7200),
            array('userDefaultCurrencyIsoCode', null),
            array('userEmail', 'foo@bar.com'),
            array('userFullName', 'Foo Bar'),
            array('userId', '005o0000000zabaAAA'),
            array('userLanguage', 'en_US'),
            array('userLocale', 'en_US'),
            array('userName', 'foo@bar.com'),
            array('userTimeZone', 'UTC'),
            array('userType', 'Standard'),
            array('userUiSkin', 'Theme3'),
        );
    }

    protected function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->testClass, $value);
    }

}
