<?php
namespace Salesforce\Soap;

/**
 * SOAP client used for the Salesforce API client
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class SoapClient extends \SoapClient implements SoapClientInterface
{

    /**
     * {@inheritDoc}
     */
    public function authenticate($login, $password, $token)
    {
        return $this->__soapCall('login', [
            $login,
            $password . $token
        ]);
    }

} 