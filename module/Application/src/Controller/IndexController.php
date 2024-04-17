<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\SigninForm;
use Application\Model\Repositories\PostRepository;
use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @var StaffRepository
     */
    protected $staffTable;

    /**
     * @var SessionContainer
     */
    protected $container;

    public function __construct(
        StaffRepository  $staffTable,
        SessionContainer $container
    )
    {
        $this->staffTable = $staffTable;
        $this->container  = $container;
    }

    /**
     * @return SigninForm[]|\Laminas\Http\Response|ViewModel
     */
    public function viewSignAction()
    {
        /** This is form view*/
        $form    = new SigninForm();
        $request = $this->getRequest();

        $session = new SessionContainer();
        if ($session->userId !== null) {
            $this->staffTable->unloginUser($session->userId);
        }
        $session->getManager()->destroy();

        if (!$request->isPost()) {
            return new ViewModel([
                'form'  => $form,
            ]);
        }
        $email            = $request->getPost('email');
        $passwordRegister = $request->getPost('passwordRegister');
        $passwordSignIn   = $request->getPost('passwordSignIn');
        $repeatPassword   = $request->getPost('repeatPassword');
        $post             = $request->getPost('dropdownPost');


        if ($passwordRegister === $repeatPassword && $passwordRegister !== null) {
            $userId = $this->staffTable->registerUser($email[0], $passwordRegister, $post);
            $this->container->getManager()->start();
            $this->container->userId  = $userId["id"];
            $this->container->isAdmin = 0;
            return $this->redirect()->toRoute('edit', [
                'action' => 'edit',
                'id'     => $session->userId
            ]);
        }

        if ($passwordSignIn !== null && $email !== null) {
            $login = $this->staffTable->loginUser($email[0], $passwordSignIn);
            if ($login) {
                $this->container->getManager()->start();
                $this->container->userId  = $login["id"];
                $this->container->isAdmin = $login["is_admin"];
                return $this->redirect()->toRoute('profile', [
                    'action' => 'profile',
                    'id'     => $this->container->userId
                ]);
            }
        }
        $this->staffTable->passwordRecovery($email[0]);

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return ['form' => $form];
        }
        return $this->redirect()->toRoute('sign');
    }

    /**
     * @return ViewModel
     */
    public function viewSettingsAction()
    {
        return new ViewModel();
    }

    /**
     * @return ViewModel
     */
    public function viewSettingsForAdminAction()
    {
        return new ViewModel();
    }
}
