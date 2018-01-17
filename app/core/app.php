<?php 

/**
 * App
 * 
 * Main class for a Mini MVC
 * 
 * Provides basic MVC functionality
 * Just proof of concept
 * 
 * 
 */
class App {
	
        /**
         * App
         * 
         * Initializes App
         */
	public function App() {
		$this->load_library('cache');
	}
	
        /**
         * load_controller
         * 
         * Loads controller into App
         * 
         * @param string $name Controller Classname
         */
	function load_controller ($name) 
	{
		$this->load_class($name,CONTROLLER_PATH);			
	}	
	
        /**
         * load_library
         * 
         * Loads library into App
         * 
         * @param string $name Library Classname
         */
	function load_library ($name) 
	{
		$this->load_class($name,LIBRARY_PATH);			
	}
	
        /**
         * load_model
         * 
         * Loads model into App
         * 
         * @param string $name Model Classname
         */
	function load_model($name) 
	{				
		$this->load_class($name,MODEL_PATH);
	}
	
        
        /**
         * load_view
         * 
         * Loads view. It can return the content or display the view
         * 
         * @param string $view Path to view
         * @param array $data Data for the view
         * @param bool $return_contents if TRUE Return View contents
         * 
         * @return string View contents
         */
	function load_view($view, $data = false, $return_contents = false) {
		
		if ($data)
                {
                        extract($data);
                }			
		
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
	
        /**
         * load_class
         * 
         * Private function to load classes into App
         * 
         * @param string $name classname
         * @param string $path path to class
         */
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


