<?php
namespace Salesforce\Exception;

/**
 * Class LoginFaultException
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class LoginFaultException extends \Exception
{

    public function __construct(\SoapFault $soapFault)
    {
        $loginFault = (array) $soapFault->detail->LoginFault;
        $message = $loginFault['enc_value']->exceptionMessage;

        parent::__construct($message, 0, $soapFault);
    }

} 