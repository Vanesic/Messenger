<?php

namespace Application\Model\Data;

class Telephones
{
    /**
     * @var array $telephone
     */
    protected $telephone;

    /**
     * @var array $id
     */
    protected $id;

    /**
     * @var array $idStaff
     */
    protected $idStaff;

    public function getTelephone(): array
    {
        return $this->telephone;
    }

    /**
     * @param array $telephone
     */
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
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
        $this->telephone = !empty($data['telephone']) ? $data['telephone'] : null;
        $this->id        = !empty($data['id']) ? $data['id'] : null;
        $this->idStaff   = !empty($data['id_staff']) ? $data['id_staff'] : null;
    }
}