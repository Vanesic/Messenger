<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\ChangepasswordForm;
use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;

class ChangePasswordController extends AbstractActionController
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
     * @return ChangepasswordForm[]|\Laminas\Http\Response
     */
    public function viewChangePasswordAction()
    {
        /** This is form view*/
        $form = new ChangepasswordForm();

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $userId = $this->container->userId;

        $previousPassword = $request->getPost("revPassword");
        $newPassword      = $request->getPost("newPassword");
        $repeatPassword   = $request->getPost("repeatPassword");


        if ($newPassword === $repeatPassword && $newPassword !== null) {
            $this->staffTable->changePassword($userId, $previousPassword, $newPassword);
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }
        return $this->redirect()->toRoute('changepassword');
    }
}