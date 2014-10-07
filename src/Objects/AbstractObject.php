<?php
namespace Salesforce\Objects;

/**
 * Abstract Salesforce Object
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
abstract class AbstractObject implements ObjectInterface, ArraySerializable
{

    /**
     * {@inheritDoc}
     */
    abstract public function asArray();

} 