<?php

class Router {
	public function Router () 
	{
		include CONFIG_PATH.'routes.php';
		$this->routes = $routes;
		
		$this->_check_routes();
		$this->_validate_request();		
	}
	
	private function _check_routes() 
	{
		$uri = $_SERVER["REQUEST_URI"];
		$uri = trim($uri,'/');
		
		$this->uri = $uri;
				
		foreach ($this->routes as $key => $val)
		{
			if (preg_match('#^'.$key.'$#', $uri))
			{
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}
				
				$this->req = explode('/', $val);
			}
		}			
		
	}
	
	private function _validate_request() 
	{
		if (isset($this->req) && is_array($this->req) && count($this->req)>0) {
			// controller name
			if (file_exists(CONTROLLER_PATH.$this->req[0].'.php'))
			{
				$this->routing['controller_name'] = $this->req[0];
			}
			
			// function name
			if (isset($this->req[1]))
			{
				$this->routing['function_name'] = $this->req[1];
			}
			else
			{
				$this->routing['function_name'] = 'index';
			}
			
			// function params
			if (count($this->req)>2)
			{
				$this->routing['function_params'] = array_slice($this->req, 2);
			}		
			else 
			{
				$this->routing['function_params'] = array();	
			}
				
			
		}
		else if ($this->uri)
		{
			$this->routing['controller_name'] = $this->routes['error404'];
			$this->routing['function_name'] = 'index';
			$this->routing['function_params'] = array();
		} 
		else 
		{
			$this->routing['controller_name'] = $this->routes['default'];
			$this->routing['function_name'] = 'index';
			$this->routing['function_params'] = array();
		}
	}
	
}
