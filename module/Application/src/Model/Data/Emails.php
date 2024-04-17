<?php

declare(strict_types=1);

namespace Application\Model\Data;

class Emails
{
    /**
     * @var array $email
     */
    protected $email;

    /**
     * @var array $id
     */
    protected $id;

    /**
     * @var array $idStaff
     */
    protected $idStaff;

    public function getEmail(): array
    {
        return $this->email;
    }

    /**
     * @param array $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getId(): array
    {
        return $this->id;
    }

    /**
     * @param array $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getIdStaff(): array
    {
        return $this->idStaff;
    }

    /**
     * @param array $idStaff
     */
    public function setIdStaff($idStaff): void
    {
        $this->idStaff = $idStaff;
    }


    public function exchangeArray(array $data)
    {
        $this->email   = !empty($data['email']) ? $data['email'] : null;
        $this->id      = !empty($data['id']) ? $data['id'] : null;
        $this->idStaff = !empty($data['id_staff']) ? $data['id_staff'] : null;
    }
}