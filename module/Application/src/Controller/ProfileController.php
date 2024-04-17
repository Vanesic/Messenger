<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\ViewModel;

class ProfileController extends AbstractActionController
{
    /**
     * @var StaffRepository
     */
    protected $staffTable;

    /**
     * @var SessionContainer
     */
    protected $container;


    public function __construct(StaffRepository $table, SessionContainer $container)
    {
        $this->staffTable = $table;
        $this->container = $container;
    }

    /**
     * @return ViewModel
     */
    public function viewProfileAction()
    {
        $userId  = $this->container->userId;

        $profileId = $this->params()->fromRoute('id', null);

        return new ViewModel([
            'emails'    => $this->staffTable->getEmail($userId),
            'phones'    => $this->staffTable->getTelephone($userId),
            'user'      => $this->staffTable->getUserInfo($userId),
            'profileId' => $profileId,
            'userId'    => $userId,
        ]);
    }
}
