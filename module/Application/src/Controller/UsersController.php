<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\UsersForm;
use Application\Model\Repositories\PostRepository;
use Application\Model\Repositories\StaffRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class UsersController extends AbstractActionController
{
    /**
     * @var StaffRepository
     */
    protected $staffTable;


    public function __construct(StaffRepository $table)
    {
        $this->staffTable = $table;
    }

    /**
     * @return JsonModel|ViewModel
     */
    public function viewUsersAction()
    {
        /** This is form view*/
        $form    = new UsersForm();
        $request = $this->getRequest();

        if (!$request->isXmlHttpRequest()) {
            return new ViewModel([
                'form'  => $form,
                'users' => $this->staffTable->getAllUsers(),
            ]);
        }
        $data     = $this->params()->fromPost();
        $jsonData = [];
        $idx      = 0;
        if (!$data['id']) {
            $searchLineSplit = explode(" ", $data['searchLine']);
            $searchLine      = "";
            foreach ($searchLineSplit as $index => $word) {
                if ($word != ' ' && $index != count($searchLineSplit) - 1) {
                    $searchLine .= "$word+";
                } else {
                    $searchLine .= "$word";
                }
            }
            $jsonData[$idx++] = iterator_to_array($this->staffTable->getUsersByFilters(
                $searchLine,
                $data['post'],
                $data['gender'] - 1,
                $data['dobBefore'],
                $data['dobAfter']
            ));
        } else {
            $jsonData[$idx++] = iterator_to_array($this->staffTable->getUsersByPagination($data['page']));
        }
        $view = new JsonModel($jsonData);
        $view->setTerminal(true);

        return $view;
    }
}