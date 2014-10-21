<?php
namespace Salesforce\Soap;

use Salesforce\Exception\LoginFaultException;

/**
 * SOAP client used for the Salesforce API client
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class SoapClient implements SoapClientInterface
{

    /**
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * Instantiate a SOAP client wrapper
     *
     * @param \SoapClient $soapClient
     */
    public function __construct(\SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate($username, $password, $token)
    {
        try {
            // "login" is a web server' method
            $result = $this->soapClient->login(array(
                'username' => $username,
                'password' => $password . $token
            ));
        } catch (\SoapFault $e) {
            throw new LoginFaultException($e);
        }

        return $result->result;
    }

    /**
     * {@inheritDoc}
     */
    public function setLocation($location)
    {
        return $this->soapClient->__setLocation($location);
    }

}