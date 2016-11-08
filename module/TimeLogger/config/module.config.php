<?php

namespace TimeLogger;

use Zend\Router\Http\Segment;

return [

    'router' => [
        'routes' => [
            'projects' => [
                'type'    => 'literal',
                'options' => [
                    'route' => '/projects',
                    'defaults' => [
                        'controller' => Controller\ProjectController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'project' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/project[/:project_id]',
                    'constraints' => [
                        'project_id' => '[0-9]+',
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'timelogs' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/timelogs',
                            'defaults' => [
                                'controller' => Controller\TimeLogController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'new' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/new',
                                    'defaults' => [
                                        'controller' => Controller\TimeLogController::class,
                                        'action'     => 'new',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
                'cache' => 'array',
                'extension' => '.dcm.yml',
                'paths' => [__DIR__ . '/mappings']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];
