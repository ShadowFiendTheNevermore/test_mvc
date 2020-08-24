<?php

namespace ShadowFiend\Core\Router;

use ShadowFiend\Core\Router\Route;
use ShadowFiend\Core\Exceptions\NotFoundException;

/**
 * Main router class
 */
class Router
{
	/**
	 * Array of all existed routes
	 * 
	 * @var array
	 */
	protected $routes = [];


	/**
	 * Request method
	 * 
	 * @var string
	 */
	protected $http_method;

	/**
	 * Current uri
	 * 
	 * @var string
	 */
	protected $uri;

	/**
	 * Namespace for controllers
	 *
	 * @var string
	 */
	protected $namespace;

	/**
	 * Set default settings for Router 
	 */
	public function __construct(string $namespace = '')
	{
		$this->host = $_SERVER['SERVER_NAME'];
		$this->http_method = $_SERVER['REQUEST_METHOD'];
		$this->uri = $this->getURI();
		$this->namespace = $namespace;
	}

	public function setNamespace(string $namespace)
	{
		$this->namespace = $namespace;
	}

	/**
	 * This method run the route via the Application class
	 * 
	 * @return
	 */
	public function run()
	{
		if (!count($this->routes)) {
			throw new \Exception("No any routes in application");
		}

		foreach ($this->routes as $route) {
			if ($route->checkEquals($this->uri) && $route->checkRequestMethod($this->http_method)) {
				return $this->runRoute($route);
			}
		}

		throw new NotFoundException('Page not found');
	}

	/**
	 * Call route action with parameters
	 * 
	 * @param  ShadowFiend\Framework\Router\Route $route
	 * @return callback;
	 */
	protected function runRoute($route)
	{
		if (is_array($route->action)) {

			$controller = new $route->action['controller'];
			$controllerAction = $route->action['controller_method'];

			call_user_func_array([$controller, $controllerAction], $route->params);
		} else {
			// Run callback
			call_user_func_array($route->action, $route->params);
		}
	}


	/**
	 * Add route to routes in Router
	 * 
	 * @param $options passed option for create new Route;
	 */
	public function addRoute(array $options)
	{
		$route = new Route();

		$routeAction = $this->makeRouteAction($options['action']);

		$route->setUri($options['uri'])
			->setAction($routeAction);


		if (array_key_exists('method', $options)) {
			$route->setMethod($options['method']);
		}


		$this->routes[] = $route;
	}

	/**
	 * Return route action as array or callable
	 * 
	 * @param  mixed $action
	 * @return mixed
	 */
	private function makeRouteAction($action)
	{
		if (is_callable($action)) {
			return $action;
		} elseif (is_string($action)) {
			return $this->getControllerForRoute($action);
		}

		throw new \Exception("Bad Action '$action' for route");
	}


	/**
	 * Return array with callable Class\Method
	 * 
	 * @param  string $controllerAction
	 * @return array                   
	 */
	private function getControllerForRoute(string $controllerAction)
	{
		$controller = $this->namespace . '\\' . $this->getControllerNameFromSegments($controllerAction);

		$controllerMethod = $this->getControllerMethodFromSegments($controllerAction);

		return ['controller' => $controller, 'controller_method' => $controllerMethod];
	}


	/**
	 * Return controller name
	 * 
	 * @param  string $segments
	 * @return string
	 */
	private function getControllerNameFromSegments($segments)
	{
		return $this->getSegmentsFromActionString($segments)[0];
	}


	/**
	 * Returns controller method
	 * 
	 * @param $controller
	 * @return string
	 */
	private function getControllerMethodFromSegments($segments)
	{
		return (string) strtolower($this->getSegmentsFromActionString($segments)[1]);
	}


	/**
	 * Splice Controller name and controller method
	 * 
	 * @param  string $action
	 * @return array
	 */
	private function getSegmentsFromActionString($action)
	{
		return explode('_', $action);
	}


	/**
	 * Returns request uri
	 * 
	 * @return string
	 */
	private function getURI()
	{
		$uri = $_SERVER['REQUEST_URI'];

		if (!empty($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/') {
			$uri = rtrim($_SERVER['REQUEST_URI'], '/');
		}

		return explode('?', $uri)[0];
	}
}
