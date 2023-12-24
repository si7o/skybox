<?php

/**
 * 
 * Router
 * 
 * 
 * Router class for controllers
 * 
 * 
 */
require_once CORE_PATH . 'routing.php';

class Router
{
	private $uri;
	private $req;
	private $routing;

	/**
	 * Router
	 *
	 * Initializes Router. Loads configured routes and sets Route params
	 * and Routing object
	 *
	 */
	public function __construct()
	{
		include CONFIG_PATH . 'routes.php';
		$this->routes = $routes;

		$this->_check_routes();
		$this->_validate_request();
	}

	/**
	 * getRouting
	 * 
	 * gets Routing object or null
	 * 
	 * @return Routing 
	 */
	public function getRouting()
	{
		if (isset($this->routing)) {
			return $this->routing;
		} else {
			return null;
		}
	}

	/**
	 * _check_routes
	 * 
	 * Private funtion that validates current request against 
	 * configured routes (routes.php in Config Folder)
	 * 
	 * It sets the request params
	 * 
	 */
	private function _check_routes()
	{
		$uri = $_SERVER["REQUEST_URI"];
		$uri = trim($uri, '/');

		$this->uri = $uri;

		foreach ($this->routes as $key => $val) {
			if (preg_match('#^' . $key . '$#', $uri)) {
				if (strpos($val, '$') !== FALSE and strpos($key, '(') !== FALSE) {
					$val = preg_replace('#^' . $key . '$#', $val, $uri);
				}

				$this->req = explode('/', $val);
			}
		}

		if (!isset($this->req) && $this->uri) {
			$this->req = explode('/', $this->uri);
		}
	}

	/**
	 * _validate_request
	 * 
	 * Validates the request params and sets Routing Object
	 *      If request is invalid it sets Routing object to 404 error page
	 *      If request is not set it sets Routing object to default route
	 * 
	 * @return boolean
	 */
	private function _validate_request()
	{
		$req_OK = false;
		$this->routing = new Routing();

		if (isset($this->req) && is_array($this->req) && count($this->req) > 0) {


			// controller name
			if (file_exists(CONTROLLER_PATH . $this->req[0] . '.php')) {
				$this->routing->setControllerName($this->req[0]);
			}

			// function name
			if (isset($this->req[1])) {
				$this->routing->setFunctionName($this->req[1]);
			}

			// function params
			if (count($this->req) > 2) {
				$this->routing->setFunctionParams(array_slice($this->req, 2));
			}
		}

		//check if the function exists within the controller
		if ($this->routing->getControllerName()) {
			$file_path = CONTROLLER_PATH . $this->routing->getControllerName() . '.php';
			$arr_name = explode('/', $this->routing->getControllerName());
			$var_name = array_pop($arr_name);
			$class_name = ucfirst($var_name);

			require_once $file_path;
			$controller = new $class_name();

			if (method_exists($controller, $this->routing->getFunctionName())) {
				//everything OK
				$req_OK = true;
			}
		}

		// Check if it's a 404 or homepage
		if ($this->uri && !$req_OK) {
			$this->routing->setControllerName($this->routes['error404']);
			$this->routing->setFunctionName('index');
			$this->routing->setFunctionParams(array());
		} else if (!$this->uri) {
			$this->routing->setControllerName($this->routes['default']);
			$this->routing->setFunctionName('index');
			$this->routing->setFunctionParams(array());
		}
	}
}
