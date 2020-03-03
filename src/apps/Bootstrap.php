<?php

use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Debug;

class Bootstrap extends Application
{
	protected $modules;

	public function __construct()
	{
		$this->modules = require APP_PATH . '/config/modules.php';
	}

	public function init()
	{
		$this->_registerServices();

		$config = $this->getDI()['config'];

		if ($config->mode == 'DEVELOPMENT') {
			$debug = new Debug();

			$debug->setBlacklist([
				'server'  => ['DB_PASSWORD'],
			]);

			$debug->listen();
		}
		
		/**
		 * Load modules
		 */
		$this->registerModules($this->modules);
		
		$response = $this->handle(
            $_SERVER["REQUEST_URI"]
        );
    
        $response->send();
	}

	private function _registerServices()
	{
		if (getenv('APPLICATION_ENV') !== 'production') {
			$envFile = ((getenv('APPLICATION_ENV') === 'testing') ? '.env.test' : '.env');
			$dotEnv = Dotenv\Dotenv::create(APP_PATH, $envFile);
			$dotEnv->load();
		}
		$env = getenv('APPLICATION_ENV');

		//env config
		if (!$env) {
			echo "Application environment not set";
			exit;
		} else {
			$config = require APP_PATH . '/config/config.php';
		}

		$defaultModule = getenv('DEFAULT_MODULE');

		$container = new FactoryDefault();
		$config = require APP_PATH . '/config/config.php';
		$modules = $this->modules;

		include_once APP_PATH . '/config/loader.php';
		include_once APP_PATH . '/config/services.php';
		include_once APP_PATH . '/config/routing.php';
		
		$this->setDI($container);
	}
}
