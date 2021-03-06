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
                'may_terminate' => true,
                'child_routes' => [
                    'create' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/create',
                            'defaults' => [
                                'controller' => Controller\ProjectController::class,
                                'action'     => 'create',
                            ],
                        ],
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
                    'update' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/update',
                            'defaults' => [
                                'controller' => Controller\ProjectController::class,
                                'action'     => 'update',
                            ],
                        ],
                    ],
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

                            'create' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'controller' => Controller\TimeLogController::class,
                                        'action'     => 'create',
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
