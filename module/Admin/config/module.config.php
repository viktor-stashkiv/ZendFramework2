<?php

return array(

    /* Псевдоніми контроллерів*/
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category' => 'Admin\Controller\CategoryController',
            'article' => 'Admin\Controller\ArticleController',
            'comment' => 'Admin\Controller\CommentController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'literal',

                'options' => array(
                    'route'    => '/admin/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),

                'may_terminate' => true,

                'child_routes' => array(

                    'category' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'category/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'category',
                                'action' => 'index'
                            ),
                        ),
                    ),

                    'article' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'article/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'article',
                                'action' => 'index'
                            ),
                        ),
                    ),

                    'comment' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'comment/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'comment',
                                'action' => 'index'
                            ),
                        ),
                    ),

                ), // child_routes
            ),  
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_navigation' => 'Admin\Lib\AdminNavigationFactory',
        ),
    ),

    'navigation' => array(

        'default' => array(
            array(
                'label' => 'Головна',
                'route' => 'home',
            ),
        ),
        'admin_navigation' => array(
            array(
                'label' => 'Панель управління сайтом',
                'route' => 'admin',
                'action' => 'index',
                'resource' =>'Admin\Controller\Index',

                'pages' => array(
                    array(
                        'label' => 'Статті',
                        'route' => 'admin/article',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавити статтю',
                        'route' => 'admin/article',
                        'action' => 'add',

                    ),
                    array(
                        'label' => 'Категорії',
                        'route' => 'admin/category',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавити категорію',
                        'route' => 'admin/category',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Коментарі',
                        'route' => 'admin/comment',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array( // пагінація
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml',
        ),
    ),

    'module_layouts' => array( // шаблон адмінки
        'Admin' => 'layout/admin-layout',
    ),

); // end main



