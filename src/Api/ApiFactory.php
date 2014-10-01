<?php
namespace Salesforce\Api;


class ApiFactory
{

    /**
     * @param string $apiName
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function getApi($apiName)
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