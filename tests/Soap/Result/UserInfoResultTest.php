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
        return [
            ['accessibilityMode', false],
            ['currencySymbol', '$'],
            ['orgAttachmentFileSizeLimit', '5242880'],
            ['orgDefaultCurrencyIsoCode', 'USD'],
            ['orgDisallowHtmlAttachments', false],
            ['orgHasPersonAccounts', false],
            ['organizationId', '00Do0000000biPkEAI'],
            ['organizationMultiCurrency', 'false'],
            ['organizationName', 'FooBar Company'],
            ['profileId', '00eo0000000x7M5AAI'],
            ['roleId', null],
            ['sessionSecondsValid', 7200],
            ['userDefaultCurrencyIsoCode', null],
            ['userEmail', 'foo@bar.com'],
            ['userFullName', 'Foo Bar'],
            ['userId', '005o0000000zabaAAA'],
            ['userLanguage', 'en_US'],
            ['userLocale', 'en_US'],
            ['userName', 'foo@bar.com'],
            ['userTimeZone', 'UTC'],
            ['userType', 'Standard'],
            ['userUiSkin', 'Theme3'],
        ];
    }

    protected function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->testClass, $value);
    }

}
