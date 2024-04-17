<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\DialogForm;
use Application\Model\Repositories\PostRepository;
use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class DialogController extends AbstractActionController
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
        StaffRepository $table,
        SessionContainer $container
    ) {
        $this->staffTable = $table;
        $this->container  = $container;
    }

    /**
     * @return JsonModel|ViewModel
     */
    public function viewChatAction()
    {
        /** This is companion id*/
        $companionId = (int)$this->params()->fromRoute('id', null);
        /** This is form view*/
        $form    = new DialogForm();
        $request = $this->getRequest();

        /** This is user id from session */
        $userId = $this->container->userId;

        if (!$request->isXmlHttpRequest()) {
            return new ViewModel([
                'form'        => $form,
                'companionId' => $companionId,
                'senderName'  => $this->staffTable->getSenderName($companionId),
                'messages'    => $this->staffTable->getMessages($userId, $companionId),
                'photo'       => $this->staffTable->getPhoto($userId),
                'userId'      => $userId,
            ]);
        }
        $data     = $this->params()->fromPost();
        $jsonData = [];
        $idx      = 0;
        if (!$data['id']) {
            $jsonData[$idx++] = $this->staffTable->sendMessage($userId, $companionId, $data['message']);
        } else {
            $jsonData[$idx++] = iterator_to_array(
                $this->staffTable->loadMessages($userId, $companionId, (int)$data['iteration'])
            );
            $jsonData[$idx++] = $this->staffTable->getPhoto($userId);
            $jsonData[$idx++] = $this->staffTable->getPhoto($companionId);
        }
        $view = new JsonModel($jsonData);
        $view->setTerminal(true);

        return $view;
    }
}