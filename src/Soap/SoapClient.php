<?php
namespace Salesforce\Soap;

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
        // "login" is a web server' method
        $result = $this->soapClient->login([
            'username' => $username,
            'password' => $password . $token
        ]);

        return $result->result;
    }

} 