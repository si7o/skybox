<?php 


class App {
	
	public function App() {
		$this->load_library('cache');
	}
	
	function load_controller ($name) 
	{
		$this->load_class($name,CONTROLLER_PATH);
			
	}	
	
	function load_library ($name) 
	{
		$this->load_class($name,LIBRARY_PATH);
			
	}
	
	function load_model($name) 
	{				
		$this->load_class($name,MODEL_PATH);
	}
	
	function load_view($view, $data = false, $return_contents = false) {
		
		if ($data)
			extract($data);
		
		ob_start();
		
		$file_path = VIEW_PATH.$view.'.php';
		if (file_exists($file_path)){
			require_once $file_path;
		}
		
		if ($return_contents===true) {
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}
		
		ob_end_flush();		
		
		
	}
	
	private function load_class($name,$path)
	{				
		$file_path = $path.$name.'.php';
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


