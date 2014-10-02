<?php
namespace Salesforce\Api;

/**
 * Salesforce REST API factory
 *
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class ApiFactory
{

    /**
     * Factory an API object by given $apiName
     *
     * @param string $apiName
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function factory($apiName)
    {
        switch ($apiName) {
            case 'bulk':
                $api = new Bulk();
                break;

            default:
                throw new \InvalidArgumentException(sprintf(
                    'Undefined api instance called: "%s"',
                    $apiName
                ));
                break;
        }

        return $api;
    }
} 