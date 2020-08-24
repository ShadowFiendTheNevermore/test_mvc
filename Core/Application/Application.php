<?php

namespace ShadowFiend\Core\Application;

use ShadowFiend\Core\View\View;
use ShadowFiend\Core\Router\Router;
use ShadowFiend\Core\Exceptions\NotFoundException;

/**
 * Main application class
 */
class Application
{
	/**
	 * Mode for check 
	 *
	 * @var string
	 */
	protected $mode = 'production';

	/**
	 * Router instance
	 * 
	 * @var ShadowFiend\Core\Router\Router
	 */
	protected $router;

	/**
	 * List of routes
	 * 
	 * @var array | ShadowFiend\Core\Router\Route
	 */
	protected $routes = [];

	/**
	 * path for application
	 * 
	 * @var string
	 */
	public $applicationPath;


	/**
	 * Set the application path and start session
	 * 
	 * @param string $path
	 * @param array $config
	 */
	public function __construct(string $path)
	{
		$this->startSession();

		$this->applicationPath = realpath($path);

		return $this;
	}

	public function setDebuggable()
	{
		$this->mode = 'debug';
	}

	public function startSession()
	{
		session_start();

		if (!isset($_SESSION['_flash'])) {
			$_SESSION['_flash'] = [
				'errors' => [],
				'messages' => []
			];
		}
	}

	/**
	 * Set router for application globaly
	 * 
	 * @param $router
	 */
	public function setRouter(Router $router)
	{
		$this->router = $router;
	}


	/**
	 * Return the app path
	 * 
	 * @return string
	 */
	public function getAppPath()
	{
		return realpath($this->applicationPath);
	}

	/**
	 * Start the application lyfecircle if routes is empty fallback to 404
	 * 
	 * @see  \ShadowFiend\Framework\Router\Router
	 * @return void
	 */
	public function run()
	{
		try {
			$this->router->run($this->routes);
		} catch (\Throwable $error) {
			if ($error instanceof NotFoundException) {
				return View::make('errors/404');
			} else {
				return View::make('errors/default', [
					'error' => $error,
					'debug' => $this->mode === 'production' ? false : true
				]);
			}
		}
	}


	/**
	 * This method handle a get request
	 * 
	 * @param  string $uri
	 * @param  string|callable $action
	 * 
	 * @return void
	 */
	public function get($uri, $action)
	{
		$this->router->addRoute([
			'action' => $action,
			'uri'    => $uri
		]);
	}


	/**
	 * This method handle a post request
	 * 
	 * @param  string $uri
	 * @param  string|callable $action
	 * 
	 * @return void
	 */
	public function post($uri, $action)
	{
		$this->router->addRoute([
			'action' => $action,
			'uri'    => $uri,
			'method' => 'POST'
		]);
	}
}
