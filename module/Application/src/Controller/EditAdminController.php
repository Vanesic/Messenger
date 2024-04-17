<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\EditForm;
use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class EditAdminController extends AbstractActionController
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
        $this->container  = $container;
    }

    /**
     * @return JsonModel|ViewModel
     */
    public function viewEditForAdminAction()
    {
        /** This is view form*/
        $form    = new EditForm();
        $request = $this->getRequest();

        /** This is user id*/
        $userId = $this->container->userId;

        if (!$request->isXmlHttpRequest()) {
            return new ViewModel([
                'form'   => $form,
                'user'   => $this->staffTable->getUserInfo($userId),
                'emails' => $this->staffTable->getEmail($userId),
                'phones' => $this->staffTable->getTelephone($userId),
            ]);
        }
        $data     = $this->params()->fromPost();
        $jsonData = [];
        if ($data['id']) {
            $this->staffTable->updateUserAdminInfo($data);
            $this->staffTable->updateEmails($data);
            $this->staffTable->updateTelephones($data);
        } else {
            $this->staffTable->deleteProfile($data);
        }
        $view = new JsonModel($jsonData);
        $view->setTerminal(true);
        return $view;
    }
}