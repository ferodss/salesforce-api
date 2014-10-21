<?php
namespace Salesforce\Objects;

/**
 * Interface to provide a method to export an object as array
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
interface ArraySerializable
{

    /**
     * Return object data as array
     *
     * @return array
     */
    public function asArray();

}