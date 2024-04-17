<?php

declare(strict_types=1);

namespace Application;

use Application\Command\EmailNotificationCommand;
use Laminas\Mvc\Controller\LazyControllerAbstractFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

$configProvider = new ConfigProvider();

return [
    'router'       => [
        'routes' => [
            'home'             => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'sign',
                    ],
                ],
            ],
            'staffsportal'     => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/staffsportal[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'sign',
                    ],
                ],
            ],
            'sign'             => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/sign[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'viewSign',
                    ],
                ],
            ],
            'profile'          => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/profile[/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\ProfileController::class,
                        'action'     => 'viewProfile',
                    ],
                ],
            ],
            'profileForAdmin'  => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/admin/profile[/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\ProfileAdminController::class,
                        'action'     => 'viewProfileForAdmin',
                    ],
                ],
            ],
            'edit'             => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/edit[/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\EditController::class,
                        'action'     => 'viewEdit',
                    ],
                ],
            ],
            'editForAdmin'     => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/admin/edit[/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\EditAdminController::class,
                        'action'     => 'viewEditForAdmin',
                    ],
                ],
            ],
            'users'            => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/users[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\UsersController::class,
                        'action'     => 'viewUsers',
                    ],
                ],
            ],
            'usersForAdmin'    => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/admin/users[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\UsersAdminController::class,
                        'action'     => 'viewUsersForAdmin',
                    ],
                ],
            ],
            'settings'         => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/settings[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'viewSettings',
                    ],
                ],
            ],
            'messages'         => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/messages[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\ChatsController::class,
                        'action'     => 'viewMessages',
                    ],
                ],
            ],
            'viewFilteredData' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/viewFilteredData[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\ChatsController::class,
                        'action'     => 'viewFilteredDialog',
                    ],
                ],
            ],
            'deletePost'       => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/deletePost[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\PostsController::class,
                        'action'     => 'deletePosts',
                    ],
                ],
            ],
            'insertPost'       => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/insertPost[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\PostsController::class,
                        'action'     => 'insertPosts',
                    ],
                ],
            ],
            'editPost'         => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/editPost[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\PostsController::class,
                        'action'     => 'editPosts',
                    ],
                ],
            ],
            'posts'            => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/admin/posts[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\PostsController::class,
                        'action'     => 'viewPosts',
                    ],
                ],
            ],
            'chat'             => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/chat/[:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\DialogController::class,
                        'action'     => 'viewChat',
                    ],
                ],
            ],
            'changepassword'   => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/changepassword[/:action]',
                    'defaults' => [
                        'controller' => Controller\ChangePasswordController::class,
                        'action'     => 'viewChangePassword',
                    ],
                ],
            ],
            'news'   => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/news[/:action]',
                    'defaults' => [
                        'controller' => Controller\NewsController::class,
                        'action'     => 'viewNews',
                    ],
                ],
            ],
            'deleteUser'   => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/deleteUser[/:action]',
                    'defaults' => [
                        'controller' => Controller\DeleteUserController::class,
                        'action'     => 'deleteUser',
                    ],
                ],
            ],
        ],
    ],
    'controllers'  => [
        'factories' => [
            Controller\IndexController::class          => ReflectionBasedAbstractFactory::class,
            Controller\ProfileController::class        => ReflectionBasedAbstractFactory::class,
            Controller\ProfileAdminController::class   => ReflectionBasedAbstractFactory::class,
            Controller\EditAdminController::class      => ReflectionBasedAbstractFactory::class,
            Controller\EditController::class           => ReflectionBasedAbstractFactory::class,
            Controller\ChangePasswordController::class => ReflectionBasedAbstractFactory::class,
            Controller\UsersAdminController::class     => ReflectionBasedAbstractFactory::class,
            Controller\UsersController::class          => ReflectionBasedAbstractFactory::class,
            Controller\ChatsController::class          => ReflectionBasedAbstractFactory::class,
            Controller\DialogController::class         => ReflectionBasedAbstractFactory::class,
            Controller\NewsController::class         => ReflectionBasedAbstractFactory::class,
            Controller\DeleteUserController::class         => ReflectionBasedAbstractFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'application/index/profile'                        => __DIR__ . '/../view/profile/layout.phtml',
            'application/profile/view-profile'                 => __DIR__ . '/../view/profile/profile.phtml',
            'application/index/view-sign'                      => __DIR__ . '/../view/signin/signInPage.phtml',
            'application/edit/view-edit'                       => __DIR__ . '/../view/edit/editProfilePage.phtml',
            'application/users/view-users'                     => __DIR__ . '/../view/users/usersPage.phtml',
            'application/index/view-settings'                  => __DIR__ . '/../view/settings/settingsPage.phtml',
            'application/news/view-news'                  => __DIR__ . '/../view/news/news.phtml',
            'application/chats/view-messages'                  => __DIR__ . '/../view/chats/chatsPage.phtml',
            'application/delete-user/delete-user'                  => __DIR__ . '/../view/deleteuser/deleteuser.phtml',
            'application/chats/view-filtered-dialog'           => __DIR__ . '/../view/chats/chatsPage.phtml',
            'application/chats/view-pagination'                => __DIR__ . '/../view/chats/chatsPage.phtml',
            'application/dialog/view-chat'                     => __DIR__ . '/../view/chats/dialogPage.phtml',
            'application/posts/view-posts'                     => __DIR__ . '/../view/posts/postManagementPage.phtml',
            'application/posts/insert-posts'                   => __DIR__ . '/../view/posts/postManagementPage.phtml',
            'application/posts/delete-posts'                   => __DIR__ . '/../view/posts/postManagementPage.phtml',
            'application/posts/edit-posts'                     => __DIR__ . '/../view/posts/postManagementPage.phtml',
            'application/change-password/view-change-password' => __DIR__ . '/../view/changepassword/changePasswordPage.phtml',
            'application/users-admin/view-users-for-admin'     => __DIR__ . '/../view/users/usersForAdminPage.phtml',
            'application/edit-admin/view-edit-for-admin'       => __DIR__ . '/../view/edit/editProfileAdminPage.phtml',
            'application/profile-admin/view-profile-for-admin' => __DIR__ . '/../view/profile/profileForAdmin.phtml',
            'error/404'                                        => __DIR__ . '/../view/error/404.phtml',
            'error/index'                                      => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
        'strategies'               => ['ViewJsonStrategy',],
    ],
];
