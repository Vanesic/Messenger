<?php

namespace Application\Model\Data;

class Dialogs
{
    /**
     * @var array $id
     */
    protected $id;

    /**
     * @var array $letter
     */
    protected $letter;

    /**
     * @var array $sendAt
     */
    protected $sendAt;

    /**
     * @var array $openAt
     */
    protected $openAt;

    /**
     * @var array $idDialog
     */
    protected $idDialog;

    /**
     * @var array $idSend
     */
    protected $idSend;

    /**
     * @var array $idGet
     */
    protected $idGet;


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

    public function getLetter(): array
    {
        return $this->letter;
    }

    /**
     * @param array $letter
     */
    public function setLetter($letter): void
    {
        $this->letter = $letter;
    }

    public function getSendAt(): array
    {
        return $this->sendAt;
    }

    /**
     * @param array $sendAt
     */
    public function setSendAt($sendAt): void
    {
        $this->sendAt = $sendAt;
    }

    public function getOpenAt(): array
    {
        return $this->openAt;
    }

    /**
     * @param array $openAt
     */
    public function setOpenAt($openAt): void
    {
        $this->openAt = $openAt;
    }

    public function getIdDialog(): array
    {
        return $this->idDialog;
    }

    /**
     * @param array $idDialog
     */
    public function setIdDialog($idDialog): void
    {
        $this->idDialog = $idDialog;
    }


    public function exchangeArray(array $data)
    {
        $this->id       = !empty($data['id']) ? $data['id'] : null;
        $this->letter   = !empty($data['letter']) ? $data['letter'] : null;
        $this->sendAt   = !empty($data['send_at']) ? $data['send_at'] : null;
        $this->openAt   = !empty($data['open_at']) ? $data['open_at'] : null;
        $this->idDialog = !empty($data['id_dialog']) ? $data['id_dialog'] : null;
        $this->idSend   = !empty($data['id_send']) ? $data['id_send'] : null;
        $this->idGet    = !empty($data['id_get']) ? $data['id_get'] : null;
    }
}