<?php
namespace Salesforce\Soap;

/**
 * Factory to create a SoapClient properly configured for the Salesforce SOAP client
 *
 * @see https://github.com/phpforce/soap-client/blob/master/src/Phpforce/SoapClient/Soap/SoapClientFactory.php
 */
class SoapClientFactory
{

    /**
     * SOAP default classmap
     *
     * @var array
     */
    protected static $classmap = array(
        'LoginResult'       => 'Salesforce\Soap\Result\LoginResult',
        'GetUserInfoResult' => 'Salesforce\Soap\Result\UserInfoResult',
    );

    /**
     * Factory a new configured SoapClient instance
     *
     * @param $wsdl
     *
     * @return SoapClientInterface
     */
    public static function factory($wsdl)
    {
        $soapClient = new \SoapClient($wsdl, array(
            'trace'      => true,
            'exceptions' => true,
            'features'   => \SOAP_SINGLE_ELEMENT_ARRAYS,
            'classmap'   => self::$classmap,
            'cache_wsdl' => \WSDL_CACHE_MEMORY,
        ));

        return new SoapClient($soapClient);
    }

}