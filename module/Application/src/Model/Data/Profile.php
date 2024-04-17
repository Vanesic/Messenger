<?php

declare(strict_types=1);

namespace Application\Model\Data;

class Profile
{
    /**
     * @var array $firstName
     */
    protected $firstName;

    /**
     * @var array $lastName
     */
    protected $lastName;

    /**
     * @var array $middleName
     */
    protected $middleName;

    /**
     * @var array $skype
     */
    protected $skype;

    /**
     * @var array $gender
     */
    protected $gender;

    /**
     * @var array $dob
     */
    protected $dob;

    /**
     * @var array $isOnline
     */
    protected $isOnline;

    public function getFirstName(): array
    {
        return $this->firstName;
    }

    /**
     * @param array $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstName = $firstname;
    }

    public function getLastName(): array
    {
        return $this->lastName;
    }

    /**
     * @param array $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getMiddleName(): array
    {
        return $this->middleName;
    }

    /**
     * @param array $middleName
     */
    public function setMiddleName($middleName): void
    {
        $this->middleName = $middleName;
    }

    public function getSkype(): array
    {
        return $this->skype;
    }

    /**
     * @param array $skype
     */
    public function setSkype($skype): void
    {
        $this->skype = $skype;
    }

    public function getGender(): array
    {
        return $this->gender;
    }

    /**
     * @param array $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function getDob(): array
    {
        return $this->dob;
    }

    /**
     * @param array $dob
     */
    public function setDob($dob): void
    {
        $this->dob = $dob;
    }

    public function getIsOnline(): array
    {
        return $this->is_online;
    }

    /**
     * @param array $is_online
     */
    public function setIsOnline($is_online): void
    {
        $this->is_online = $is_online;
    }

    public function getEmails(): array
    {
        return $this->emails;
    }

    /**
     * @param array $emails
     */
    public function setEmails($emails): void
    {
        $this->emails = $emails;
    }


    public function exchangeArray(array $data)
    {
        $this->firstName  = !empty($data['firstname']) ? $data['firstname'] : null;
        $this->lastName   = !empty($data['lastname']) ? $data['lastname'] : null;
        $this->middleName = !empty($data['middlename']) ? $data['middlename'] : null;
        $this->gender     = !empty($data['gender']) ? $data['gender'] : null;
        $this->skype      = !empty($data['skype']) ? $data['skype'] : null;
        $this->dob        = !empty($data['dob']) ? $data['dob'] : null;
        $this->isOnline   = !empty($data['is_online']) ? $data['is_online'] : null;
    }
}