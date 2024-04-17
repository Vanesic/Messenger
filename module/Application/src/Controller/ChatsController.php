<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\ChatsForm;
use Application\Model\Repositories\PostRepository;
use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;


class ChatsController extends AbstractActionController
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
    public function viewMessagesAction()
    {
        /** This is form view */
        $form    = new ChatsForm();
        $request = $this->getRequest();

        /** This is user id from session */
        $userId = $this->container->userId;

        if (!$request->isXmlHttpRequest()) {
            return new ViewModel([
                'form'                 => $form,
                'dialogsExist'         => $this->staffTable->getAllExistDialogs($userId),
                'latestMessageAndTime' => $this->staffTable->getLastMessage(
                    $userId,
                    $this->staffTable->getAllExistDialogs($userId)
                ),
                'dialogsNotExist'      => $this->staffTable->getAllNotExistDialogs($userId),
                'userId'               => $userId,
            ]);
        }
        $data     = $this->params()->fromPost();
        $jsonData = [];
        $idx      = 0;
        if (!$data["id"]) {
            $searchLineSplit = explode(" ", $data["searchLine"]);
            $searchLine      = "";
            foreach ($searchLineSplit as $index => $word) {
                if ($word != ' ' && $index != count($searchLineSplit) - 1) {
                    $searchLine .= "$word+";
                } else {
                    $searchLine .= "$word";
                }
            }
            $jsonData[$idx++] = iterator_to_array($this->staffTable->getDialogsByFilters(
                $searchLine,
                $data["post"],
                $data["gender"] - 1,
                $data["dobBefore"],
                $data["dobAfter"],
            ));
        }
        $view = new JsonModel($jsonData);
        $view->setTerminal(true);

        return $view;
    }

    /**
     * @return JsonModel
     */
    public function viewFilteredDialogAction()
    {
        /** This is user id from session */
        $userId           = $this->container->userId;
        $data             = $this->params()->fromPost();
        $jsonData         = [];
        $idx              = 0;
        $jsonData[$idx++] = iterator_to_array(
            $this->staffTable->getExistDialogForPagination($userId, $data["page"])
        );
        $jsonData[$idx++] = iterator_to_array(
            $this->staffTable->getNotExistDialogForPagination($userId, $data["page"])
        );
        $jsonData[$idx++] = iterator_to_array($this->staffTable->getAllExistDialogs($userId));
        $jsonData[$idx++] = iterator_to_array($this->staffTable->getAllNotExistDialogs($userId));
        $jsonData[$idx++] = $this->staffTable->getLastMessage(
            $userId,
            $this->staffTable->getAllExistDialogs($userId)
        );
        $view             = new JsonModel($jsonData);
        $view->setTerminal(true);

        return $view;
    }
}