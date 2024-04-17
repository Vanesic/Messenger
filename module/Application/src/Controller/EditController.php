<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\Repositories\StaffRepository;
use Application\Form\EditForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class EditController extends AbstractActionController
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
    public function viewEditAction()
    {
        /** This is form view*/
        $form    = new EditForm();
        $request = $this->getRequest();


        $userId = $this->container->userId;

        $viewModel = [
            'form'   => $form,
            'user'   => $this->staffTable->getUserInfo($userId),
            'emails' => $this->staffTable->getEmail($userId),
            'phones' => $this->staffTable->getTelephone($userId),
        ];

        if (!$request->isXmlHttpRequest()) {
            return new ViewModel($viewModel);
        }
        $data     = $this->params()->fromPost();
        $jsonData = [];
        $this->staffTable->updateUserInfo($data);
        $this->staffTable->updateEmails($data);
        $this->staffTable->updateTelephones($data);
        $view = new JsonModel($jsonData);
        $view->setTerminal(true);
        return $view;
    }
}