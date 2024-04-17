<?php

namespace Application\Controller;

use Application\Form\ChangepasswordForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class DeleteUserController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function deleteUserAction()
    {
        $form = new ChangepasswordForm();
        return new ViewModel([
            'form'  => $form
        ]);
    }
}