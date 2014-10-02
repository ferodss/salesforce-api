<?php
namespace Salesforce\Soap;

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
     * @throws \SoapFault
     */
    public function authenticate($username, $password, $token);

} 