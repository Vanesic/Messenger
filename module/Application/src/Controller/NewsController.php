<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Form\NewsForm;

class NewsController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function viewNewsAction()
    {
    $form = new NewsForm();
        return new ViewModel([
         'form'  => $form,
        ]);
    }
}