<?php
namespace Salesforce\Objects;

/**
 * Salesforce Account Object
 *
 * @see https://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_account.htm
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class Account extends AbstractObject
{

    /**
     * Phone number for a account
     *
     * @var string
     */
    protected $phone;

    /**
     * ID of the record type assigned to this object.
     *
     * @var string
     */
    protected $recordTypeId;

    /**
     * Set the phone number for a account
     *
     * @param string $phone
     *
     * @return Account
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the phone number for a account
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the ID of the record type assigned to this object
     *
     * @param string $recordTypeId
     *
     * @return Account
     */
    public function setRecordTypeId($recordTypeId)
    {
        $this->recordTypeId = $recordTypeId;

        return $this;
    }

    /**
     * Gets ID of the record type assigned to this object
     *
     * @return string
     */
    public function getRedordTypeId()
    {
        return $this->recordTypeId;
    }

    /**
     * {@inheritDoc}
     */
    public function getObjectType()
    {
        return 'Account';
    }

    /**
     * {@inheritDoc}
     */
    public function asArray()
    {
        return array(
            'Phone'        => $this->getPhone(),
            'RecordTypeId' => $this->getRedordTypeId(),
        );
    }

}