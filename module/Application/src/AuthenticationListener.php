<?php

namespace Application;

use Application\Controller\EditAdminController;
use Application\Controller\EditController;
use Application\Controller\IndexController;
use Application\Controller\PostsController;
use Application\Controller\UsersAdminController;
use Application\Controller\UsersController;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container as SessionContainer;

class AuthenticationListener extends AbstractListenerAggregate
{
    /**
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            [$this, 'userHasAuthentication']
        );
    }

    /**
     * @param MvcEvent $e
     * @return void
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function userHasAuthentication(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if ($routeMatch) {
            $routeName = $routeMatch->getMatchedRouteName();
            if ($routeName !== 'sign') {
                $session = $e->getApplication()->getServiceManager()->get(SessionContainer::class);
                if (!isset($session->userId)) {
                    $routeMatch->setParam('controller', IndexController::class);
                    $routeMatch->setParam('action', 'sign');
                    $e->getResponse()->setStatusCode(401);
                }
                if (!$session->isAdmin) {
                    if ($routeName === 'editForAdmin' || $routeName === "edit") {
                        $routeMatch->setParam('controller', EditController::class);
                        $routeMatch->setParam('action', 'viewEdit');
                    }
                    if ($routeName === 'usersForAdmin' || $routeName === 'users') {
                        $routeMatch->setParam('controller', UsersController::class);
                        $routeMatch->setParam('action', 'viewUsers');
                    }
                } else {
                    if ($routeName === 'edit' || $routeName === "editForAdmin") {
                        $routeMatch->setParam('controller', EditAdminController::class);
                        $routeMatch->setParam('action', 'viewEditForAdmin');
                    }
                    if ($routeName === 'usersForAdmin' || $routeName === "users") {
                        $routeMatch->setParam('controller', UsersAdminController::class);
                        $routeMatch->setParam('action', 'viewUsersForAdmin');
                    }
                }
            }
        }
    }
}