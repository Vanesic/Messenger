<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Application\Command\EmailNotificationCommand;

return [
    'db' => [
        'driver'   => 'Pdo_Mysql',
        'database' => 'Staff',
        'username' => 'danil',
        'password' => '2493',
        'hostname' => 'localhost',
        'port'     => '3306',
    ],

    'session_containers' => [
        Laminas\Session\Container::class,
    ],
    'session_storage'    => [
        'type' => Laminas\Session\Storage\SessionArrayStorage::class,
    ],
    'session_config' => [
        'gc_maxlifetime' => 7200,
    ],
    'laminas-cli' => [
        'commands' => [
            'package:command-name' => Application\Command\EmailNotificationCommand::class,
        ],
    ],
    'dependencies' => [
        'factories' => [
            \Application\Command\EmailNotificationCommand::class => \Application\Command\EmailNotificationCommandFactory::class,
        ],
    ],
];
