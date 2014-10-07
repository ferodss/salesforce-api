<?php
namespace Salesforce\Objects;

/**
 * Salesforce PersonAccount Object
 *
 * @see https://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_account.htm#i1438505
 * @author Felipe Rodrigues <lfrs.web@gmail.com>
 */
class PersonAccount extends Account
{

    /**
     * First name of the person for a person account
     *
     * @var string
     */
    protected $firstName;

    /**
     * Last name of the person for a person account
     *
     * @var string
     */
    protected $lastName;

    /**
     * Birth date of the person for a person account
     *
     * @var \Datetime
     */
    protected $personBirthDate;

    /**
     * Email address for a person account
     *
     * @var string
     */
    protected $personEmail;

    /**
     * The mobile phone number for a person account
     *
     * @var string
     */
    protected $personMobilePhone;

    /**
     * Set the first name of the person for a person account
     *
     * @param string $firstName
     *
     * @return PersonAccount
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the first name of the person for a person account
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the last name of the person for a person account
     *
     * @param string $lastName
     *
     * @return PersonAccount
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the last name of the person for a person account
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the birth date of the person for a person account
     *
     * @param \Datetime $personBirthDate
     *
     * @return PersonAccount
     */
    public function setPersonBirthDate(\Datetime $personBirthDate)
    {
        $this->personBirthDate = $personBirthDate;

        return $this;
    }

    /**
     * Get birth date of the person for a person account
     *
     * @return \Datetime
     */
    public function getPersonBirthDate()
    {
        return $this->personBirthDate;
    }

    /**
     * Set the email address for a person account
     *
     * @param string $personEmail
     *
     * return PersonAccount
     */
    public function setPersonEmail($personEmail)
    {
        $this->personEmail = $personEmail;

        return $this;
    }

    /**
     * Get the email address for a person account
     *
     * @return string
     */
    public function getPersonEmail()
    {
        return $this->personEmail;
    }

    /**
     * Set the mobile phone number for a person account
     *
     * @param string $personMobilePhone
     *
     * @return PersonAccount
     */
    public function setPersonMobilePhone($personMobilePhone)
    {
        $this->personMobilePhone = $personMobilePhone;

        return $this;
    }

    /**
     * Get the mobile phone number for a person account
     *
     * @return string
     */
    public function getPersonMobilePhone()
    {
        return $this->personMobilePhone;
    }

    /**
     * {@inheritDoc}
     */
    public function asArray()
    {
        $data = parent::asArray();

        return array_merge($data, [
            'FirstName'         => $this->getFirstName(),
            'LastName'          => $this->getLastName(),
            'PersonBirthDate'   => $this->getPersonBirthDate(),
            'PersonEmail'       => $this->getPersonEmail(),
            'PersonMobilePhone' => $this->getPersonMobilePhone(),
        ]);
    }

} 