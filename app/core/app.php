<?php 


class App {
	public function App() {
		
	}
	
	public static function &get_instance()
	{
		return self::$instance;
	}	
	
	function load_controller ($name) {
		$file_path = CONTROLLER_PATH.$name.'.php';
		
		$arr_name = explode('/',$name);
		$var_name = array_pop($arr_name);
		$class_name = ucfirst($var_name);
		
		if (file_exists($file_path)){
			require_once $file_path;
			if (!isset ($this->$var_name ) )
				$this->$var_name = new $class_name();
		}
			
	}
	
	function load_view($view, $data = false) {
		
		if ($data)
			extract($data);		
		
		$file_path = VIEW_PATH.$view.'.php';
		if (file_exists($file_path)){
			require_once $file_path;
		}
		
	}
	
	function load_model($name) {				
		$file_path = MODEL_PATH.$name.'.php';
		$arr_name = explode('/',$name);
		$var_name = array_pop($arr_name);
		$class_name = ucfirst($var_name);
		
		if (file_exists($file_path)){
			require_once $file_path;
			if (!isset ($this->$var_name ) )
				$this->$var_name = new $class_name();
		}
		
	}
}


