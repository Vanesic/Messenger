<?php

declare(strict_types=1);

namespace Application;

use Application\Command\EmailNotificationCommand;
use Application\Model\Data\Emails;
use Application\Model\Data\Telephones;
use Application\Model\Data\Post;
use Application\Model\Data\Profile;
use Application\Model\Repositories\StaffRepository;
use Application\Model\Resources\DialogResources;
use Application\Model\Resources\EmailResources;
use Application\Model\Resources\PostResources;
use Application\Model\Resources\TelephoneResources;
use Application\Model\Resources\StaffResources;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Mvc\MvcEvent;
use Symfony\Component\Console\Command\Command;


class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;

    }

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();

        $authenticationListener = new AuthenticationListener();
        $authenticationListener->attach($app->getEventManager());
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\Repositories\StaffRepository::class => function ($container) {
                    $tableGateway       = $container->get(Model\Resources\StaffResources::class);
                    $emailResources     = $container->get(Model\Resources\EmailResources::class);
                    $telephoneResources = $container->get(Model\Resources\TelephoneResources::class);
                    return new Model\Repositories\StaffRepository($tableGateway, $emailResources, $telephoneResources);
                },
                Model\Repositories\PostRepository::class  => function ($container) {
                    $tableGateway = $container->get(Model\Resources\PostResources::class);
                    return new Model\Repositories\PostRepository($tableGateway);
                },

                Model\Resources\StaffResources::class     => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $dialogResources    = new DialogResources('messages', $dbAdapter, null, $resultSetPrototype);
                    $emailResources     = new EmailResources($dialogResources, 'emails', $dbAdapter, null, $resultSetPrototype);
                    $telephoneResources = new TelephoneResources('telephones', $dbAdapter, null, $resultSetPrototype);
                    $resultSetPrototype->setArrayObjectPrototype(new Profile());
                    return new StaffResources($emailResources, $telephoneResources, $dialogResources, 'staffs', $dbAdapter, null, $resultSetPrototype, null);
                },
                Model\Resources\EmailResources::class     => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $dialogResources    = new DialogResources('messages', $dbAdapter, null, $resultSetPrototype);
                    $resultSetPrototype->setArrayObjectPrototype(new Emails());
                    return new EmailResources($dialogResources, 'emails', $dbAdapter, null, $resultSetPrototype);
                },
                Model\Resources\TelephoneResources::class => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Telephones());
                    return new TelephoneResources('telephones', $dbAdapter, null, $resultSetPrototype);
                },

                EmailNotificationCommand::class => function ($container) {
                    $tableGateway       = $container->get(Model\Resources\StaffResources::class);
                    $emailResources     = $container->get(Model\Resources\EmailResources::class);
                    $telephoneResources = $container->get(Model\Resources\TelephoneResources::class);
                    $staffTable         = new StaffRepository($tableGateway, $emailResources, $telephoneResources);
                    return new EmailNotificationCommand($staffTable);
                }
            ],
        ];
    }
}

