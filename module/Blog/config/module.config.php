<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'blog_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'D:\xampp\htdocs\module\Blog\src\Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Blog\Entity' => 'blog_entity'
                )
            )
        )
    ), // end doctrine config

    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'blog' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/[:action/][:id/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ':id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),  

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
); // end main



