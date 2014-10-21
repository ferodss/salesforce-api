<?php
namespace Salesforce\Objects;

/**
 * Salesforce Object interface
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
interface ObjectInterface
{

    /**
     * Returns the Salesforce object type
     *
     * @see https://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_list.htm
     *
     * @return string
     */
    public function getObjectType();

}