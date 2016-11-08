<?php
namespace TimeLogger;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ProjectTable::class => function($container) {
                    $entityManager = $container->get('doctrine.entitymanager.orm_default');
                    return new Model\ProjectTable($entityManager);
                },

                Model\TimeLogTable::class => function($container) {
                    $entityManager = $container->get('doctrine.entitymanager.orm_default');
                    return new Model\TimeLogTable($entityManager);
                }
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProjectController::class => function($container) {
                    return new Controller\ProjectController(
                        $container->get(Model\ProjectTable::class)
                    );
                },

                Controller\TimeLogController::class => function($container) {
                    return new Controller\TimeLogController(
                        $container->get(Model\TimeLogTable::class),
                        $container->get(Model\ProjectTable::class)
                    );
                },
            ],
        ];
    }
}
