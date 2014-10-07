<?php
namespace Salesforce\Soap;

use Salesforce\Soap\Exception\LoginFaultException;

/**
 * SOAP client interface used for the Salesforce API client
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
interface SoapClientInterface
{

    /**
     * Logs in to the login server and starts a client session
     *
     * @param string $username Salesforce username
     * @param string $password Salesforce password
     * @param string $token    Salesforce security token
     *
     * @link http://www.salesforce.com/us/developer/docs/api/Content/sforce_api_calls_login.htm
     *
     * @return Result\LoginResult
     *
     * @throws LoginFaultException
     */
    public function authenticate($username, $password, $token);

    /**
     * Sets the location of the Web service to use
     *
     * @link http://php.net/manual/en/soapclient.setlocation.php
     *
     * @param string $new_location [optional]    The new endpoint URL.
     *
     * @return string The old endpoint URL.
     */
    public function setLocation($location);

} 