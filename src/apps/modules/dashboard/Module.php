<?php

namespace Its\Example\Dashboard;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([

            'Its\Example\Dashboard\Core\Domain\Event' => __DIR__ . '/Core/Domain/Event',
            'Its\Example\Dashboard\Core\Domain\Model' => __DIR__ . '/Core/Domain/Model',
            'Its\Example\Dashboard\Core\Domain\Repository' => __DIR__ . '/Core/Domain/Repository',
            'Its\Example\Dashboard\Core\Domain\Service' => __DIR__ . '/Core/Domain/Service',

            'Its\Example\Dashboard\Core\Application\Service' => __DIR__ . '/Core/Application/Service',
            'Its\Example\Dashboard\Core\Application\EventSubscriber' => __DIR__ . '/Core/Application/EventSubscriber',

            'Its\Example\Dashboard\Infrastructure\Persistence' => __DIR__ . '/Core/Infrastructure/Persistence',

            'Its\Example\Dashboard\Presentation\Web\Controller' => __DIR__ . '/Presentation/Web/Controller',
            'Its\Example\Dashboard\Presentation\Web\Validator' => __DIR__ . '/Presentation/Web/Validator',
            'Its\Example\Dashboard\Presentation\Api\Controller' => __DIR__ . '/Presentation/Api/Controller',
            
        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        include_once __DIR__ . '/config/services.php';
    }
}