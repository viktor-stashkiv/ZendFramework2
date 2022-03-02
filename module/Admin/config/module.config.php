<?php

return array(
    /*'doctrine' => array(
        'driver' => array(
            'admin_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'D:\xampp\htdocs\module\Admin\src\Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Admin\Entity' => 'admin_entity'
                )
            )
        )
    ), // end doctrine config*/

    /* Псевдоніми контроллерів*/
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category' => 'Admin\Controller\CategoryController',
            'article' => 'Admin\Controller\ArticleController'
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

                ), // child_routes
            ),  
        ),
    ),  

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
); // end main



