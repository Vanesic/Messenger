<?php

namespace Application;


use Application\Command\EmailNotificationCommand;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'laminas-cli'  => $this->getCliConfig(),
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    public function getCliConfig(): array
    {
        return [
            'commands' => [
                'package:command-name' => EmailNotificationCommand::class,
            ],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                \Application\Command\EmailNotificationCommand::class => \Application\Command\EmailNotificationCommandFactory::class,
            ],
        ];
    }
}