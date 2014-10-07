<?php
namespace Salesforce\Objects;

use Salesforce\Api\Bulk\XMLSerializable;

/**
 * Abstract Salesforce Object
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
abstract class AbstractObject implements ObjectInterface, XMLSerializable
{

    /**
     * {@inheritDoc}
     */
    abstract public function asXML();

} 